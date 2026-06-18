<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $atasan = Category::where('name', 'Atasan')->firstOrFail();
        $bawahan = Category::where('name', 'Bawahan')->firstOrFail();

        Product::create([
            'category_id' => $atasan->id,
            'name' => 'Kaos Polos Hitam',
            'price' => 100000,
            'stock' => 100,
        ]);

        Product::create([
            'category_id' => $atasan->id,
            'name' => 'Kemeja Pria Lengan Pendek',
            'price' => 150000,
            'stock' => 100,
        ]);

        Product::create([
            'category_id' => $bawahan->id,
            'name' => 'Celana Jeans Denim',
            'price' => 250000,
            'stock' => 100,
        ]);

        Product::create([
            'category_id' => $bawahan->id,
            'name' => 'Celana Chino Panjang',
            'price' => 200000,
            'stock' => 100,
        ]);

        Product::create([
            'category_id' => $atasan->id,
            'name' => 'Jaket Varsity (Flash Sale)',
            'price' => 50000,
            'stock' => 50,
        ]);
    }
}
