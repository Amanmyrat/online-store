<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use App\Transformers\ProductTransformer;

class ProductController extends ApiController
{
    public function index(ProductFilterRequest $request)
    {
        $validated = $request->validated();
        $products = $this->filterProducts($validated);
        
        return $this->respondWithCollection($products, new ProductTransformer());
    }

    public function getProductsBySlug($slug)
    {
        $products = Product::with(['category', 'specifications']);
        if (isset($slug)) {
            $products->where('slug', 'LIKE', '%' . $slug . '%');            
        }else{
            return $this->errorWrongArgs();
        }
        return $this->respondWithCollection($products->get(), new ProductTransformer());
    }

    private function filterProducts($request)
    {
        $products = Product::with(['category', 'specifications']);

        if (isset($request['name'])) {
            $products->where('name', 'LIKE', '%' . $request['name'] . '%');
        }
        if (isset($request['price'])) {
            $products->where('price', '>', intval($request['price']));
        }
        if (isset($request['categories'])) {
            $products->whereIn('category_id', $request['categories']);
        }
        if (isset($request['specification_name']) && isset($request['specification_value'])) {
            $products->whereHas('specifications', function ($query) use ($request) {
                $query->where('name', $request['specification_name'])
                    ->where('value', $request['specification_value']);
            });
        }

        return $products->get();
    }
}
