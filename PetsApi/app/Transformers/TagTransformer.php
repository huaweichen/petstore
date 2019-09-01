<?php

namespace App\Transformers;

use App\Models\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    /**
     * Transform `tag`.
     * @param Tag|null $tag
     * @return array
     */
    public function transform(?Tag $tag): array
    {
        return null === $tag ? [] : [
            'id' => $tag->id,
            'name' => $tag->name,
        ];
    }
}
