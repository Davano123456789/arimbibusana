<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Categories
        $categories = [
            ['name' => 'Mukena', 'slug' => 'mukena'],
            ['name' => 'Scarf', 'slug' => 'scarf'],
            ['name' => 'Hijab', 'slug' => 'hijab'],
            ['name' => 'Busana Muslim', 'slug' => 'busana-muslim'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        // 2. Products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Mukena Silk Premium Arimbi',
                'slug' => 'mukena-silk-premium-arimbi',
                'description' => 'Mukena berbahan silk premium yang sangat lembut dan dingin di kulit. Cocok untuk ibadah harian maupun mahar pernikahan.',
                'price' => 450000,
                'stock' => 50,
                'is_best_seller' => true,
                'is_recommended' => true,
                'status' => 'active',
            ],
            [
                'category_id' => 2,
                'name' => 'Scarf Voal Ultra Fine',
                'slug' => 'scarf-voal-ultra-fine',
                'description' => 'Scarf berbahan voal ultra fine yang mudah dibentuk dan tidak mudah kusut. Tersedia dalam berbagai pilihan warna elegan.',
                'price' => 125000,
                'stock' => 100,
                'is_best_seller' => true,
                'is_recommended' => false,
                'status' => 'active',
            ],
            [
                'category_id' => 3,
                'name' => 'Hijab Satin Silk Square',
                'slug' => 'hijab-satin-silk-square',
                'description' => 'Hijab segi empat berbahan satin silk yang memberikan kesan glamor dan elegan untuk acara formal.',
                'price' => 85000,
                'stock' => 75,
                'is_best_seller' => false,
                'is_recommended' => true,
                'status' => 'active',
            ],
            [
                'category_id' => 4,
                'name' => 'Gamis Rayon Twill Eksklusif',
                'slug' => 'gamis-rayon-twill-eksklusif',
                'description' => 'Gamis nyaman berbahan rayon twill dengan potongan yang modern dan elegan. Busui friendly.',
                'price' => 320000,
                'stock' => 30,
                'is_best_seller' => false,
                'is_recommended' => false,
                'status' => 'active',
            ],
        ];

        foreach ($products as $prodData) {
            $product = \App\Models\Product::create($prodData);

            // 3. Product Images (using placeholder or mock paths)
            // Note: These images won't exist in storage yet, but the paths will be in DB
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => 'products/sample-' . $product->id . '.jpg',
            ]);

            // 4. Product Sizes
            $sizes = ['S', 'M', 'L', 'XL'];
            foreach ($sizes as $size) {
                \App\Models\ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'stock' => rand(5, 20),
                ]);
            }
        }
    }
}
