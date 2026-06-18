<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ShippingController extends Controller
{
    protected $apiKey;
    protected $baseUrl;
    protected $originPostalCode;
    protected $originLatitude;
    protected $originLongitude;

    public function __construct()
    {
        $this->apiKey = config('services.biteship.key');
        $this->baseUrl = 'https://api.biteship.com/v1';
        $this->originPostalCode = config('services.biteship.origin_postal_code', '60281');
        $this->originLatitude = config('services.biteship.origin_latitude', -7.2756);
        $this->originLongitude = config('services.biteship.origin_longitude', 112.7541);
    }

    /**
     * Get Provinces using free Static JSON API
     */
    public function getProvinces()
    {
        return Cache::remember('wilayah_provinces', 60 * 24 * 30, function () {
            $response = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
            return $response->json();
        });
    }

    /**
     * Get Cities using free Static JSON API
     */
    public function getCities($provinceId)
    {
        return Cache::remember('wilayah_cities_' . $provinceId, 60 * 24 * 30, function () use ($provinceId) {
            $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
            return $response->json();
        });
    }

    /**
     * Get Districts using free Static JSON API
     */
    public function getDistricts($cityId)
    {
        return Cache::remember('wilayah_districts_' . $cityId, 60 * 24 * 30, function () use ($cityId) {
            $response = Http::get("https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$cityId}.json");
            return $response->json();
        });
    }

    protected function getCoordinates($postalCode, $province = null, $city = null, $district = null)
    {
        $query = "$postalCode, Indonesia";
        if ($district && $city && $province) {
            $query = "$district, $city, $province, Indonesia";
        }
        
        $cacheKey = 'geocode_location_' . md5($query);
        
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if ($cached) {
                return $cached;
            }
        }

        // 1. Try Nominatim (OpenStreetMap) first
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            ])->timeout(5)->get('https://nominatim.openstreetmap.org/search', [
                'q' => $query,
                'format' => 'json',
                'limit' => 1
            ]);

            if ($response->successful() && count($response->json()) > 0) {
                $item = $response->json()[0];
                $coords = [
                    'latitude' => (double)$item['lat'],
                    'longitude' => (double)$item['lon']
                ];
                
                Cache::put($cacheKey, $coords, 60 * 24 * 30);
                return $coords;
            }
        } catch (\Exception $e) {
            Log::error("Geocoding failed for query {$query}: " . $e->getMessage());
        }

        // 2. Fallback: Query Biteship area API which guarantees to have coordinates for serviced postal codes
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/maps/areas', [
                'countries' => 'ID',
                'input' => $postalCode,
                'type' => 'single'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['areas']) && count($data['areas']) > 0) {
                    $area = $data['areas'][0];
                    if (isset($area['latitude']) && isset($area['longitude'])) {
                        $coords = [
                            'latitude' => (double)$area['latitude'],
                            'longitude' => (double)$area['longitude']
                        ];
                        
                        Cache::put($cacheKey, $coords, 60 * 24 * 30);
                        return $coords;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("Biteship geocoding fallback failed for postal code {$postalCode}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Get Shipping Cost from Biteship
     */
    public function getCost(Request $request)
    {
        try {
            $destinationPostalCode = $request->destination_postal_code;
            $weight = $request->weight ?? 1000;
            $courier = $request->courier ?? 'jnt';
            $province = $request->province;
            $city = $request->city;
            $district = $request->district;

            if (!$destinationPostalCode) {
                return response()->json(['error' => 'Kode pos tujuan diperlukan'], 400);
            }

            // Create a unique cache key based on route, weight and courier
            $cacheKey = "biteship_cost_{$this->originPostalCode}_{$destinationPostalCode}_{$weight}_{$courier}";

            return Cache::remember($cacheKey, 60 * 24, function () use ($destinationPostalCode, $weight, $courier, $province, $city, $district) {
                Log::info("Biteship Cost Request (LIVE): From {$this->originPostalCode} to {$destinationPostalCode} ({$weight}g)");

                $payload = [
                    'origin_postal_code' => (int)$this->originPostalCode,
                    'destination_postal_code' => (int)$destinationPostalCode,
                    'couriers' => $courier,
                    'items' => [
                        [
                            'name' => 'Produk Arimbi Busana',
                            'description' => 'Produk Pakaian',
                            'value' => 100000,
                            'weight' => (int)$weight,
                            'quantity' => 1
                        ]
                    ]
                ];

                // Paxel requires precise latitude and longitude for both origin and destination
                if ($courier === 'paxel') {
                    // Origin coordinates (read from config)
                    $payload['origin_latitude'] = $this->originLatitude;
                    $payload['origin_longitude'] = $this->originLongitude;

                    // Geocode the destination postal code and text query to get coordinates
                    $coords = $this->getCoordinates($destinationPostalCode, $province, $city, $district);
                    if ($coords) {
                        $payload['destination_latitude'] = $coords['latitude'];
                        $payload['destination_longitude'] = $coords['longitude'];
                    } else {
                        Log::warning("Could not geocode destination location {$destinationPostalCode} ({$district}, {$city}, {$province}) for Paxel rates.");
                    }
                }

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])->post($this->baseUrl . '/rates/couriers', $payload);

                if ($response->failed()) {
                    Log::error('Biteship Cost Error: ' . $response->status() . ' - ' . $response->body());
                    throw new \Exception('Gagal menghitung ongkos kirim');
                }

                $data = $response->json();
                $results = [];
                if (isset($data['pricing']) && is_array($data['pricing'])) {
                    foreach ($data['pricing'] as $price) {
                        $cost = $price['price'];
                        $duration = $price['duration'];

                        // Duration and cost override/markup logic for Paxel
                        if ($courier === 'paxel') {
                            // Add a markup of 1.500 to match the retail/manual app price
                            $cost = $cost + 1500;

                            // Since Biteship API hardcodes Paxel description as "8 - 12 hours" for all routes,
                            // we dynamically determine actual Paxel transit times based on destination postal code:
                            $firstDigit = substr($destinationPostalCode, 0, 1);
                            $firstTwoDigits = substr($destinationPostalCode, 0, 2);

                            if ($firstDigit === '6') {
                                // Jawa Timur (Same Province) -> Sameday
                                $duration = 'Sameday';
                            } elseif (in_array($firstDigit, ['1', '4', '5']) || $firstTwoDigits === '80') {
                                // Jawa & Bali (DKI Jakarta, Banten, Jabar, Jateng, DIY, and Bali 80xxx) -> Nextday (1-2 days)
                                $duration = 'Nextday';
                            } else {
                                // Luar Jawa & Bali (Sumatera 2/3, Kalimantan 7, Sulawesi/Papua 9, NTB/NTT 83/85) -> Regular 3-5 days
                                $duration = '3 - 5'; // Will display as "3 - 5 Hari" on the frontend
                            }
                        }

                        $results[] = [
                            'service' => $price['courier_service_name'],
                            'description' => $price['description'],
                            'cost' => $cost,
                            'etd' => $duration
                        ];
                    }
                }

                return $results;
            });

        } catch (\Exception $e) {
            Log::error('Biteship Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan sistem'], 500);
        }
    }
    /**
     * Search Postal Code from Biteship based on Province, City, and District names
     */
    public function getPostalCode(Request $request)
    {
        try {
            $province = $request->province;
            $city = $request->city;
            $district = $request->district;

            if (!$district) {
                return response()->json(['error' => 'Kecamatan diperlukan'], 400);
            }

            $keyword = "{$district}, {$city}, {$province}";
            
            // Check cache first to save API balance
            $cacheKey = 'postal_code_' . md5($keyword);
            
            return Cache::remember($cacheKey, 60 * 24 * 30, function () use ($keyword) {
                Log::info("Biteship Area Search (LIVE): {$keyword}");

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ])->get($this->baseUrl . '/maps/areas', [
                    'countries' => 'ID',
                    'input' => $keyword,
                    'type' => 'single'
                ]);

                if ($response->failed()) {
                    Log::error('Biteship Area Search Error: ' . $response->status() . ' - ' . $response->body());
                    return response()->json(['error' => 'Gagal mencari kode pos'], 500);
                }

                $data = $response->json();
                
                if (isset($data['areas']) && count($data['areas']) > 0) {
                    $area = $data['areas'][0];
                    return [
                        'postal_code' => $area['postal_code'],
                        'full_name' => $area['name']
                    ];
                }

                return response()->json(['error' => 'Kode pos tidak ditemukan'], 404);
            });

        } catch (\Exception $e) {
            Log::error('Biteship Area Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan sistem'], 500);
        }
    }
}
