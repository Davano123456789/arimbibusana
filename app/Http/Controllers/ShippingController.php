<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingController extends Controller
{
    protected $apiKey;
    protected $baseUrl;
    protected $origin;

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key', env('RAJAONGKIR_API_KEY'));
        $this->baseUrl = config('services.rajaongkir.base_url', env('RAJAONGKIR_BASE_URL', 'https://api.rajaongkir.com/starter'));
        $this->origin = config('services.rajaongkir.origin', env('RAJAONGKIR_ORIGIN', 444)); // Default Surabaya (444)
    }

    public function getProvinces()
    {
        try {
            Log::info('Komerce Province Request: ' . $this->baseUrl . '/destination/province');
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/destination/province');

            if ($response->failed()) {
                Log::error('Komerce Province Error: ' . $response->status() . ' - ' . $response->body());
                return response()->json(['error' => 'Gagal mengambil data provinsi'], 500);
            }

            $data = $response->json();
            Log::info('Komerce Province Response: ' . json_encode($data));
            return $data['data'] ?? $data['rajaongkir']['results'] ?? [];
        } catch (\Exception $e) {
            Log::error('Komerce Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    public function getCities($provinceId)
    {
        try {
            Log::info('Komerce City Request: ' . $this->baseUrl . '/destination/city/' . $provinceId);
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->get($this->baseUrl . '/destination/city/' . $provinceId);

            if ($response->failed()) {
                Log::error('Komerce City Error: ' . $response->status() . ' - ' . $response->body());
                return response()->json(['error' => 'Gagal mengambil data kota'], 500);
            }

            $data = $response->json();
            Log::info('Komerce City Response: ' . json_encode($data));
            return $data['data'] ?? $data['rajaongkir']['results'] ?? [];
        } catch (\Exception $e) {
            Log::error('Komerce Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan sistem'], 500);
        }
    }

    public function getCost(Request $request)
    {
        try {
            $destination = $request->destination;
            $weight = $request->weight ?? 1000;
            $courier = $request->courier ?? 'jnt';

            Log::info('Komerce Cost Request: ' . $this->baseUrl . '/calculate/domestic-cost with destination ' . $destination);

            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->asForm()->post($this->baseUrl . '/calculate/domestic-cost', [
                'origin' => $this->origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            ]);

            if ($response->failed()) {
                Log::error('Komerce Cost Error: ' . $response->status() . ' - ' . $response->body());
                return response()->json(['error' => 'Gagal menghitung ongkir'], 500);
            }

            $data = $response->json();
            Log::info('Komerce Cost Response: ' . json_encode($data));
            return $data['data'] ?? $data['rajaongkir']['results'] ?? [];
        } catch (\Exception $e) {
            Log::error('Komerce Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan sistem'], 500);
        }
    }
}
