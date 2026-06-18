<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function all($paginate = true, int $limit = 10)
    {
        return Product::with('category')->fetch($paginate, $limit);
    }

    public function find($id)
    {
        return Product::with('category')->findOrFail($id);
    }
}
