<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class PetService extends ApiBaseService
{

    public $baseUri;

    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.pet.base_url');
        $this->secret = config('services.pet.api_key');
    }

    /**
     * @param Request $request
     * @return string
     * @throws GuzzleException
     */
    public function getPetById($petId): string
    {
        return $this->send('GET', "/pet/{$petId}");
    }

    /**
     * @param Request $request
     * @return string
     * @throws GuzzleException
     */
    public function createNewPet(Request $request): string
    {
        return $this->send('POST', '/pet', $request->toArray());
    }

    /**
     * @param Request $request
     * @return string
     * @throws GuzzleException
     */
    public function updatePetById(Request $request, $petId): string
    {
        return $this->send('POST', "/pet/{$petId}", $request->toArray());
    }

    /**
     * @param Request $request
     * @return string
     * @throws GuzzleException
     */
    public function deletePetById($petId): string
    {
        return $this->send('DELETE', "/pet/{$petId}");
    }

}
