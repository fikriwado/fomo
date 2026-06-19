<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TransactionItem::query()->delete();
        Transaction::query()->delete();

        $products = Product::query()->inRandomOrder()->limit(4)->get();
        $firstProduct = $products->firstOrFail();
        $secondProducts = $products->skip(1)->take(3)->values();

        // --------------------------------------------------------
        // -------------- SAMPLE | FRIST TRANSACTION --------------
        // --------------------------------------------------------
        $firstQuantity = 1;

        $firstTransaction = Transaction::create([
            'total_amount' => (float) $firstProduct->price * $firstQuantity,
        ]);

        TransactionItem::create([
            'transaction_id' => $firstTransaction->id,
            'product_id' => $firstProduct->id,
            'quantity' => $firstQuantity,
            'price' => $firstProduct->price,
        ]);

        // --------------------------------------------------------
        // ------------- SAMPLE | SECOND TRANSACTION --------------
        // --------------------------------------------------------
        $secondQuantity = 2;

        $secondTransaction = Transaction::create([
            'total_amount' => $secondProducts->values()
                ->map(fn (Product $product): float => (float) $product->price * $secondQuantity)
                ->sum(),
        ]);

        foreach ($secondProducts as $product) {
            TransactionItem::create([
                'transaction_id' => $secondTransaction->id,
                'product_id' => $product->id,
                'quantity' => $secondQuantity,
                'price' => $product->price,
            ]);
        }
    }
}
