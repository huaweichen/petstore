<?php

namespace App\Http\Controllers;

use App\Exceptions\PetInvalidArgumentException;
use App\Repositories\Repository;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ApiResponser;

    /**
     * @var Repository
     */
    public $repository;

    public function __construct(
        Repository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param $petId
     * @return JsonResponse
     */
    public function get($petId): JsonResponse
    {
        if ( ! is_numeric($petId)) {
            throw new PetInvalidArgumentException('Invalid ID supplied');
        }

        $result = $this->repository->getPet($petId);

        return $this->successResponse($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function save(Request $request): JsonResponse
    {
        $rules = [
            'name' => 'required|max:255',
            'category.id' => 'numeric',
            'category.name' => 'max:255',
            'tags.*.id' => 'numeric',
            'tags.*.name' => 'max:255',
            'status' => 'required|in:available,pending,sold',
        ];
        $this->validate($request, $rules);

        $result = $this->repository->savePet($request->toArray());

        return $this->successResponse($result, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param $petId
     * @return JsonResponse
     * @throws ValidationException
     */
    public function edit(Request $request, $petId): JsonResponse
    {
        if ( ! is_numeric($petId)) {
            throw new PetInvalidArgumentException('Invalid ID supplied');
        }

        $rules = [
            'name' => 'max:255',
            'status' => 'in:available,pending,sold',
        ];
        $this->validate($request, $rules);

        $result = $this->repository->updatePet($request->toArray(), $petId);

        return $this->successResponse($result);
    }

    /**
     * @param $petId
     * @return JsonResponse
     */
    public function delete($petId): JsonResponse
    {
        if ( ! is_numeric($petId)) {
            throw new PetInvalidArgumentException('Invalid ID supplied.');
        }

        $result = $this->repository->deletePet($petId);

        return $this->successResponse($result);
    }
}
