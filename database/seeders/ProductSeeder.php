<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'name' => 'Iphone 12',
                'slug' => 'celulares',
                'description' => 'Iphone con 64 gb',
                'price' => 599.99,
                'stock' => 10,
            ],
            [
                'category_id' => 2,
                'name' => 'Campera de Invierno',
                'slug' => 'campera',
                'description' => 'Campera de Invierno de cuero',
                'price' => 300,
                'stock' => 7,
            ],
        ];
        foreach ($products as $product) {
            Product::create($product);
        }


    }
}


