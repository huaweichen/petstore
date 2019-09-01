<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    /**
     * Transform `category`.
     * @param Category|null $category
     * @return array
     */
    public function transform(?Category $category): array
    {
        return null === $category ? [] : [
            'id' => $category->id,
            'name' => $category->name,
        ];
    }

}
