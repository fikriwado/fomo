<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\Process\Process;

uses(DatabaseMigrations::class);

pest()->group('transaction');

function purchaseProductProcess(Product $product): Process
{
    $script = <<<PHP
        try {
            app(App\Services\TransactionService::class)->store([
                'items' => [
                    ['product_id' => {$product->id}, 'quantity' => 1],
                ],
            ]);

            echo 'success';
        } catch (Throwable) {
            echo 'failed';
        }
    PHP;

    return new Process([PHP_BINARY, base_path('artisan'), 'tinker', '--execute', $script]);
}

test('make sure generating code', function () {
    $transaction = Transaction::create([
        'total_amount' => 100000,
    ]);

    expect($transaction->code)
        ->not->toBeNull()
        ->toBeString()
        ->toStartWith('INV-')
        ->toMatch('/^INV-\d{4,6}-[A-Z0-9]{5}$/');

    $secondTransaction = Transaction::create([
        'total_amount' => 150000,
    ]);

    expect($secondTransaction->code)->not->toBe($transaction->code);
});

test('prevent negative inventory during race condition', function () {
    $category = Category::create([
        'name' => 'Flash Sale Category'
    ]);

    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Flash Sale Item',
        'price' => 50000,
        'stock' => 1,
    ]);

    $first = purchaseProductProcess($product);
    $second = purchaseProductProcess($product);

    $first->start();
    $second->start();

    $first->wait();
    $second->wait();

    $results = [
        trim($first->getOutput()),
        trim($second->getOutput()),
    ];

    expect($product->refresh()->stock)->toBe(0)
        ->and(Transaction::count())->toBe(1)
        ->and($results)->toContain('success')
        ->and($results)->toContain('failed');
});
