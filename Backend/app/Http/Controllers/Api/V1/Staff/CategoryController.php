<?php

namespace App\Http\Controllers\Api\V1\Staff;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return $this->success(CategoryResource::collection($categories), 'Categories retrieved successfully');
    }
}
