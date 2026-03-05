<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'is_tiktok_live', 'value' => '0'],
            ['key' => 'tiktok_username', 'value' => 'arimbiqueen'],
            ['key' => 'tiktok_live_url', 'value' => 'https://www.tiktok.com/@arimbiqueen/live'],
            ['key' => 'store_address', 'value' => 'Jl. Pattimura No. 123, Surabaya'],
            ['key' => 'contact_whatsapp', 'value' => '628123456789'],
            ['key' => 'contact_email', 'value' => 'admin@arimbiqueen.com'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/arimbiqueen'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
