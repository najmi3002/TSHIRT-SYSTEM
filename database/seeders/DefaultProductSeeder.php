<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DefaultProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::updateOrCreate(
            ['name' => 'Default Product'],
            [
                'price' => 0, 
                'collar_type' => json_encode([
                    ['name' => 'Round Neck', 'addon_price' => 0],
                    ['name' => 'V-Neck', 'addon_price' => 2],
                    ['name' => 'Polo', 'addon_price' => 5],
                ]),
                'fabric_type' => json_encode([
                    ['name' => 'Cotton', 'addon_price' => 0],
                    ['name' => 'Microfiber', 'addon_price' => 3],
                ]),
                'sleeve_type' => json_encode([
                    ['name' => 'Short Sleeve', 'addon_price' => 0],
                    ['name' => 'Long Sleeve', 'addon_price' => 4],
                ]),
                'image_path' => 'images/default_product.jpg'
            ]
        );
    }
}
