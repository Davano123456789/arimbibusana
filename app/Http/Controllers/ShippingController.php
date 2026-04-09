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

    public function __construct()
    {
        $this->apiKey = config('services.biteship.key');
        $this->baseUrl = 'https://api.biteship.com/v1';
        $this->originPostalCode = config('services.biteship.origin_postal_code', '60111');
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

    /**
     * Get Shipping Cost from Biteship
     */
    public function getCost(Request $request)
    {
        try {
            $destinationPostalCode = $request->destination_postal_code;
            $weight = $request->weight ?? 1000;
            $courier = $request->courier ?? 'jnt';

            if (!$destinationPostalCode) {
                return response()->json(['error' => 'Kode pos tujuan diperlukan'], 400);
            }

            // Create a unique cache key based on route, weight and courier
            $cacheKey = "biteship_cost_{$this->originPostalCode}_{$destinationPostalCode}_{$weight}_{$courier}";

            return Cache::remember($cacheKey, 60 * 24, function () use ($destinationPostalCode, $weight, $courier) {
                Log::info("Biteship Cost Request (LIVE): From {$this->originPostalCode} to {$destinationPostalCode} ({$weight}g)");

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])->post($this->baseUrl . '/rates/couriers', [
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
                ]);

                if ($response->failed()) {
                    Log::error('Biteship Cost Error: ' . $response->status() . ' - ' . $response->body());
                    throw new \Exception('Gagal menghitung ongkos kirim');
                }

                $data = $response->json();
                
                $results = [];
                if (isset($data['pricing']) && is_array($data['pricing'])) {
                    foreach ($data['pricing'] as $price) {
                        $results[] = [
                            'service' => $price['courier_service_name'],
                            'description' => $price['description'],
                            'cost' => $price['price'],
                            'etd' => $price['duration']
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
