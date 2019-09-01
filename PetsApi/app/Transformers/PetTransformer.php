<?php

namespace App\Transformers;

use App\Models\Pet;
use Illuminate\Support\Facades\App;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class PetTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'category',
        'tags',
    ];

    /**
     * Transform `pet`.
     * @param Pet $pet
     * @return array
     */
    public function transform(Pet $pet): array
    {
        return [
            'id' => $pet->id,
            'name' => $pet->name,
            'photoUrls' => json_decode($pet->photoUrls),
            'status' => $pet->status,
        ];
    }

    /**
     * Include `category` with `pet`.
     * @param Pet $pet
     * @return Item
     */
    public function includeCategory(Pet $pet): Item
    {
        return $this->item($pet->category, App::make(CategoryTransformer::class));
    }

    /**
     * Include `tags` with `pet`.
     * @param Pet $pet
     * @return Collection
     */
    public function includeTags(Pet $pet): Collection
    {
        return $this->collection($pet->tags, App::make(TagTransformer::class));
    }

}
