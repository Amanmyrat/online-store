<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform($category)
    {
        $children = array();
        foreach ($category->children as $child) {
            array_push($children, (object)[
                'id' => $child->id,
                'name' => $child->name,
                'children' => $child->children,
            ]);
        }
        return [
            'id' => $category->id,
            'name' => $category->name,
            'children' => $children
        ];
    }
}
