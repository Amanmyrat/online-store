<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform($order)
    {
        return [
            'id' => $order->id,
            'user_name' => $order->user_name,
            'user_email' => $order->user_email,
            'address' => $order->address,
            'status' => $order->status,
            'total' => $order->total,
            'products' => json_decode($order->products, true),
        ];
    }
}
