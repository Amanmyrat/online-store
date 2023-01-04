<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Models\Order;
use App\Models\ShoppingCart;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    public function checkout(Request $request)
    {
        $user = auth('sanctum')->user();

        $validatedData = $request->validate($user ? [
            'address' => 'required|string|max:255',
        ] :
            [
                'guest_id' => 'required|integer',
                'user_name' => 'required|string|max:255',
                'user_email' => 'required|email',
                'address' => 'required|string|max:255',
            ]);

        if (isset($user)) {
            $cart_items = ShoppingCart::where('user_id', $user->id)->get();
        } else if (isset($validatedData['guest_id'])) {
            $cart_items = ShoppingCart::where('guest_id', $validatedData['guest_id'])->get();
        } else {
            return $this->errorWrongArgs();
        }

        if (count($cart_items)) {
            $total = 0;
            $products = array();
            foreach($cart_items as $item){
                $total += $item->quantity * $item->product->price;
                array_push($products, (object)[
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                ]);
            }

            $order = [
                'user_id' => $user ? $user->id : null,
                'guest_id' => $user ? null : $validatedData['guest_id'],
                'user_name' => $user ? $user->name : $validatedData['user_name'],
                'user_email' => $user ? $user->email : $validatedData['user_email'],
                'address' => $validatedData['address'],
                'total' => $total,
                'products' => json_encode($products),
            ];
            Order::create($order);

            foreach($cart_items as $item){
                $item->delete();
            }
        } else {
            return $this->errorNotFound();
        }

        return $this->respondWithMessage("Order created successfully");
    }

    public function orders()
    {
        $orders = auth('sanctum')->user()->orders;
        return $this->respondWithCollection($orders, new OrderTransformer());
    }
}
