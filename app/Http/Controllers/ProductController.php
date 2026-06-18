<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $data = $this->productService->all(true);
        $data = collectPaginate($data, ProductResource::class);
        return $this->resSuccess($data);
    }

    public function show($id)
    {
        $data = $this->productService->find($id);
        $data = ProductResource::make($data);
        return $this->resSuccess($data);
    }
}
