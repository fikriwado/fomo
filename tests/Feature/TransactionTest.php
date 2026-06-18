<?php

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

pest()->group('transaction');

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
