<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $data = $this->transactionService->all(true);
        $data = collectPaginate($data, TransactionResource::class);
        return $this->resSuccess($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $data = $this->transactionService->store($validated);
        $data = TransactionResource::make($data);
        return $this->resCreated($data);
    }

    public function show($id)
    {
        $data = $this->transactionService->find($id);
        $data = TransactionResource::make($data);
        return $this->resSuccess($data);
    }
}
