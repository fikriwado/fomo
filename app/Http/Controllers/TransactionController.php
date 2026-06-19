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
        //
    }

    public function show($id)
    {
        $data = $this->transactionService->find($id);
        $data = TransactionResource::make($data);
        return $this->resSuccess($data);
    }
}
