<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function all($paginate = true, int $limit = 10)
    {
        return Category::fetch($paginate, $limit);
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }
}
