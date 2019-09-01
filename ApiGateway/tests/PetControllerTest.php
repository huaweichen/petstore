<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class PetControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testAnGetExistingPet()
    {
        $this->get('/pet/1', [
            'Content-Type' => 'application/json',
            'api_key' => 'special-key',
        ]);
        $this->seeStatusCode(200);
        $this->seeJson(['id' => 1]);
        $this->seeJsonStructure([
            'id',
            'name',
            'photoUrls',
            'status',
            'category',
            'tags',
        ]);
    }

    public function testShouldGetUnauthorisedException()
    {
        $this->get('/pet/1', [
            'Content-Type' => 'application/json',
            'api_key' => 'invalid-key',
        ]);
        $this->seeStatusCode(401);
        $this->seeJsonEquals([
            'code' => 401,
            'type' => 'error',
            'message' => 'Unauthorized',
        ]);
    }

    public function testShouldGetInvalidIDSupplied()
    {
        $this->get('/pet/id-is-not-number', [
            'Content-Type' => 'application/json',
            'api_key' => 'special-key',
        ]);
        $this->seeStatusCode(400);
        $this->seeJsonEquals([
            'code' => 400,
            'type' => 'error',
            'message' => 'Invalid ID supplied',
        ]);
    }

    public function testPetNotFound()
    {
        $this->get('/pet/99999999', [
            'Content-Type' => 'application/json',
            'api_key' => 'special-key',
        ]);
        $this->seeStatusCode(404);
        $this->seeJsonEquals([
            'code' => 404,
            'type' => 'error',
            'message' => 'Pet not found',
        ]);
    }

    public function testShouldCreateANewPetAndNewCategoryAndNewTags()
    {
        $this->post('/pet', [
            'category' => ['name' => 'new species'],
            'name' => 'new pet',
            'photoUrls' => ['http://test.jpg', 'http://test.png'],
            'tags' => [
                ['name' => 'smart'],
                ['name' => 'can code'],
            ],
            'status' => 'sold',
        ], ['api_key' => 'special-key',]);
        $this->seeStatusCode(201);
    }

    public function testShouldNotCreateANewPetButUpdatePetDetails()
    {
        $this->post('/pet', [
            'category' => ['name' => 'new species'],
            'id' => 1,
            'name' => 'new pet',
            'photoUrls' => ['http://test.jpg', 'http://test.png'],
            'tags' => [
                ['name' => 'smart'],
                ['name' => 'can code'],
            ],
            'status' => 'sold',
        ], ['api_key' => 'special-key',]);
        $this->seeStatusCode(201);
    }

    public function testShouldCreateANewPetAndOneNewTagButUpdateCategoryNameAndTagName()
    {
        $this->post('/pet', [
            'category' => [
                'id' => 1,
                'name' => 'new species'
            ],
            'name' => 'new pet',
            'photoUrls' => ['http://test.jpg', 'http://test.png'],
            'tags' => [
                [
                    'id' => 1,
                    'name' => 'smart'
                ],
                ['name' => 'can code'],
            ],
            'status' => 'sold',
        ], ['api_key' => 'special-key']);
        $this->seeStatusCode(201);
        $this->seeJson([
            'category' => ['id' => 1, 'name' => 'new species'],
        ]);
    }

    public function testShouldReturnServerErrorWhenDataIsSeverelyBroken()
    {
        $this->post('/pet', [
            'category' => 123321,
            'name' => 'new pet',
            'photoUrls' => ['http://test.jpg', 'http://test.png'],
            'tags' => [
                [
                    'smart' // no 'name'
                ],
                [
                    1 // no id
                ],
            ],
            'status' => 'sold',
        ], ['api_key' => 'special-key',]);
        $this->seeStatusCode(500);
    }

    public function testShouldNotFoundThisPet()
    {
        $this->post('/pet/999999999', [
            'name' => 'new pet',
            'status' => 'pending',
        ], ['api_key' => 'special-key',]);
        $this->seeStatusCode(404);
    }

    public function testShouldBeABadRequest()
    {
        $this->post('/pet/asdffdsasda', [
            'name' => 'new pet',
            'status' => 'pending',
        ], ['api_key' => 'special-key',]);
        $this->seeStatusCode(400);
    }

    public function testShouldBeInvalidInput()
    {
        $this->post('/pet/1', [
            'id' => 'id should not be string',
            'name' => ['this name', 'must be a string'],
            'status' => 'non-exist-status',
        ], ['api_key' => 'special-key',]);
        $this->seeStatusCode(405);
    }
}
