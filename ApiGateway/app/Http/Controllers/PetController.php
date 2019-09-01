<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use App\Traits\ApiResponser;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class PetController extends BaseController
{
    use ApiResponser;

    /**
     * @var PetService
     */
    public $petService;

    /**
     * PetController constructor.
     * @param PetService $petService
     */
    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    /**
     * @param $petId
     * @return Response
     * @throws GuzzleException
     */
    public function get($petId): Response
    {
        return $this->successResponse($this->petService->getPetById($petId));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws GuzzleException
     */
    public function save(Request $request): Response
    {
        return $this->successResponse($this->petService->createNewPet($request), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param $petId
     * @return Response
     * @throws GuzzleException
     */
    public function edit(Request $request, $petId): Response
    {
        return $this->successResponse($this->petService->updatePetById($request, $petId));
    }

    /**
     * @param $petId
     * @return Response
     * @throws GuzzleException
     */
    public function delete($petId): Response
    {
        return $this->successResponse($this->petService->deletePetById($petId));
    }
}
