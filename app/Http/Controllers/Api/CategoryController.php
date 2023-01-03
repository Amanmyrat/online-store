<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->orWhere('parent_id',0)->get();
        return $this->respondWithCollection($categories, new CategoryTransformer());
    }
}
