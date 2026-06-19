<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionService
{
    public function all($paginate = true, int $limit = 10)
    {
        return Transaction::with('items.product.category')->fetch($paginate, $limit);
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $items = [];
            $totalAmount = 0;

            $requestedItems = collect($data['items'])
                ->groupBy('product_id')
                ->map(function ($items, $productId) {
                    return [
                        'product_id' => (int) $productId,
                        'quantity' => $items->sum('quantity'),
                    ];
                })
                ->sortBy('product_id')
                ->values();

            foreach ($requestedItems as $index => $item) {
                $product = Product::query()
                    ->whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        "items.$index.quantity" => [
                            "Stock for {$product->name} is not enough.",
                        ],
                    ]);
                }

                $quantity = $item['quantity'];
                $price = $product->price;
                $subtotal = $price * $quantity;

                $product->decrement('stock', $quantity);

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ];

                $totalAmount += $subtotal;
            }

            $transaction = Transaction::create([
                'total_amount' => $totalAmount,
            ]);

            $transaction->items()->createMany($items);

            return $transaction->load('items.product.category');
        });
    }

    public function find($id)
    {
        return Transaction::with('items.product.category')->findOrFail($id);
    }
}
