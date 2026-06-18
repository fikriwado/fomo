<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function all()
    {
        return Category::paginate(10);
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }
}
