<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;

class ProductSpecificationController extends ApiController
{
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);
        
        $product = Product::where('id',$validatedData['product_id'])->get();

        if(count($product)){
             ProductSpecification::create([
                'product_id' => $validatedData['product_id'],
                'name' => $validatedData['name'],
                'value' => $validatedData['value'],
            ]);
        }else{
            return $this->errorNotFound();
        }

        return $this->respondWithMessage("Successfully added new specification to the product");
    }

    public function destroy(ProductSpecification $productSpecification)
    {
        $productSpecification->delete();
        return $this->respondWithMessage("Successfully deleted specification from the product");
    }
}
