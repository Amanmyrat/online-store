<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ProductSpecificaationTransformer extends TransformerAbstract
{
    public function transform($specification)
    {
        return [
            'id' => $specification->id,
            'name' => $specification->name,
            'value' => $specification->value,
        ];
    }
}
