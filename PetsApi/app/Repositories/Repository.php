<?php

namespace App\Repositories;

use App\Exceptions\PetApiException;
use App\Models\Category;
use App\Models\Pet;
use App\Models\Tag;
use App\Serializers\PetSerializer;
use App\Transformers\PetTransformer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class Repository
{
    public $fractal;
    public $petTransformer;

    public function __construct(
        Manager $fractal,
        PetTransformer $petTransformer
    ) {
        $this->fractal = $fractal;
        $this->petTransformer = $petTransformer;
    }

    /**
     * Get a `pet`.
     * @param $petId
     * @return array
     */
    public function getPet($petId): array
    {
        $pet = Pet::findOrFail($petId);

        return $this->transform($pet);
    }

    /**
     * Create a new `pet`.
     * @param $data
     * @return array
     */
    public function savePet($data): array
    {
        $pet = DB::transaction(function () use ($data) {
            // Create or update `category`.
            $categoryId = Arr::get($data, 'category.id');
            $categoryName = Arr::get($data, 'category.name');
            if (null === $categoryId && null === $categoryName) {
                throw new PetApiException('Error: Server Error');
            }
            $newCategory = Category::updateOrCreate([
                'id' => $categoryId,
            ], [
                'name' => $categoryName,
            ])->only(['id']);
            $categoryId = $newCategory['id'];

            // Create or update `tag`.
            $newTagIds = [];
            if (array_key_exists('tags', $data) && count($data['tags']) > 0) {
                foreach ($data['tags'] as $tag) {
                    $tagId = Arr::get($tag, 'id');
                    $tagName = Arr::get($tag, 'name');
                    if (null === $tagId && null === $tagName) {
                        throw new PetApiException('Error: Server Error');
                    }
                    $newTagIds[] = Tag::updateOrCreate([
                        'id' => $tagId,
                    ], [
                        'name' => $tagName,
                    ])->only(['id']);
                }
            }

            // Create or update `pet`.
            $id = Arr::get($data, 'id');
            $name = Arr::get($data, 'name', '');
            $status = Arr::get($data, 'status');
            $photoUrls = Arr::get($data, 'photoUrls', []);
            $pet = Pet::updateOrCreate([
                'id' => $id,
            ], [
                'category_id' => $categoryId,
                'name' => $name,
                'photoUrls' => json_encode($photoUrls, JSON_UNESCAPED_SLASHES),
                'status' => $status,
            ]);

            // Update `pet_tag`.
            $pet->tags()->detach();
            $pet->tags()->attach(Arr::pluck($newTagIds, 'id'));

            return $pet;
        });

        return $this->transform($pet);
    }

    /**
     * Update a `pet`.
     * @param array $data
     * @param int $petId
     * @return array
     */
    public function updatePet(array $data, int $petId): array
    {
        $pet = Pet::findOrFail($petId);

        $fill = [];
        if ( ! empty($data['name'])) {
            $fill['name'] = $data['name'];
        }
        if ( ! empty($data['status'])) {
            $fill['status'] = $data['status'];
        }
        $pet->fill($fill);

        $pet->save();

        return $this->transform($pet);
    }

    /**
     * Delete a `pet`.
     * @param int $petId
     * @return array
     */
    public function deletePet(int $petId): array
    {
        $pet = Pet::findOrFail($petId);
        $pet->delete();

        return $this->transform($pet);
    }

    /**
     * Transform to a `pet`
     * @param Pet $pet
     * @return array
     */
    protected function transform(Pet $pet): array
    {
        $petItem = new Item($pet, $this->petTransformer);
        $this->fractal
            ->setSerializer(new PetSerializer())
            ->parseIncludes(['tags', 'category']);

        return $this->fractal->createData($petItem)->toArray();
    }
}
