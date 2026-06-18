<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $data = $this->categoryService->all(true);
        $data = collectPaginate($data, CategoryResource::class);
        return $this->resSuccess($data);
    }

    public function show($id)
    {
        $data = $this->categoryService->find($id);
        $data = CategoryResource::make($data);
        return $this->resSuccess($data);
    }
}
