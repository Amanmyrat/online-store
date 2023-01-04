<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShoppingCartController extends ApiController
{
    public function store(Request $request)
    {
        $user = auth('sanctum')->user();

        $guestValidation = $user ? '' : 'required|integer';
        $validatedData = $request->validate([
            'guest_id' => $guestValidation,
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        $product = Product::where('id', $validatedData['product_id'])->get();

        if (count($product)) {
            ShoppingCart::create([
                'user_id' => $user ? $user->id : null,
                'guest_id' => $user ? null : $validatedData['guest_id'],
                'product_id' => $validatedData['product_id'],
                'quantity' => $validatedData['quantity']
            ]);
        } else {
            return $this->errorNotFound();
        }

        return $this->respondWithMessage("Successfully added product to cart");
    }

    public function updateQuantity(Request $request)
    {
        $user = auth('sanctum')->user();

        $guestValidation = $user ? '' : 'required|integer';
        $validatedData = $request->validate([
            'guest_id' => $guestValidation,
            'cart_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        $cart = ShoppingCart::where('id', $validatedData['cart_id'])->get()->first();
        
        if ($cart) {
            if (isset($user) && $user->id == $cart->user_id || isset($validatedData['guest_id']) && $validatedData['guest_id'] == $cart->guest_id) {
                $cart->quantity = $validatedData['quantity'];
                $cart->save();
            } else {
                return $this->errorForbidden();
            }
        } else
            return $this->errorNotFound();
        return $this->respondWithMessage("Successfully updated quantity of cart items product");
    }

    public function destroy(Request $request)
    {
        $user = auth('sanctum')->user();

        $guestValidation = $user ? '' : 'required|integer';
        $validatedData = $request->validate([
            'guest_id' => $guestValidation,
            'cart_id' => 'required|integer',
        ]);

        $cart = ShoppingCart::where('id', $validatedData['cart_id'])->get()->first();

        if ($cart) {
            if (isset($user) && $user->id == $cart->user_id || isset($validatedData['guest_id']) && $validatedData['guest_id'] == $cart->guest_id) {
                $cart->delete();
            } else {
                return $this->errorForbidden();
            }
        } else
            return $this->errorNotFound();
        return $this->respondWithMessage("Successfully deleted product from the cart items");
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
