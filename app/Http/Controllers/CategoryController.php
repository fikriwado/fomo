<?php

namespace App\Http\Controllers;

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
        $data = $this->categoryService->all();
        return $this->resSuccess($data);
    }

    public function show($id)
    {
        $data = $this->categoryService->find($id);
        return $this->resSuccess($data);
    }
}
