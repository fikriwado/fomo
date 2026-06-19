<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function all($paginate = true, int $limit = 10)
    {
        return Transaction::with('items.product.category')->fetch($paginate, $limit);
    }

    public function store($request)
    {
        //
    }

    public function find($id)
    {
        return Transaction::with('items.product.category')->findOrFail($id);
    }
}
