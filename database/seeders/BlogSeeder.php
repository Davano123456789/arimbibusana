<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\BlogPost::create([
            'title' => 'Tips Memilih Mukena yang Nyaman untuk Ibadah Harian',
            'slug' => 'tips-memilih-mukena-nyaman',
            'thumbnail' => null,
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'excerpt' => 'Menemukan mukena yang tepat bisa meningkatkan kenyamanan ibadah Anda. Simak tips berikut untuk memilih bahan dan model yang paling sesuai.',
            'author' => 'Admin Arimbi',
            'status' => 'published',
            'published_at' => now(),
        ]);

        \App\Models\BlogPost::create([
            'title' => 'Tren Warna Busana Muslimah 2026: Anggun dan Kalem',
            'slug' => 'tren-warna-busana-muslimah-2026',
            'thumbnail' => null,
            'content' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'excerpt' => 'Warna-warna bumi dan pastel masih menjadi primadona di tahun ini. Cari tahu bagaimana memadupadankannya dengan koleksi kami.',
            'author' => 'Fashion Editor',
            'status' => 'published',
            'published_at' => now(),
        ]);

        \App\Models\BlogPost::create([
            'title' => 'Cara Merawat Scarf Voal Agar Tetap Awet dan Tegak',
            'slug' => 'cara-merawat-scarf-voal',
            'thumbnail' => null,
            'content' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'excerpt' => 'Scarf voal memerlukan perawatan khusus saat mencuci dan menyetrika. Berikut panduan lengkapnya agar scarf kesayangan Anda tidak mudah rusak.',
            'author' => 'Team Arimbi',
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
