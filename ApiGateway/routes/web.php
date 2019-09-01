<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->group([
    'middleware' => 'auth',
    'prefix' => 'pet',
], function () use ($router) {
    /**
     * Find a pet by ID.
     */
    $router->get('/{petId}', 'PetController@get');

    /**
     * Add a new pet to the store.
     */
    $router->post('/', 'PetController@save');

    /**
     * Update a pet in the store with form data.
     */
    $router->post('/{petId}', 'PetController@edit');

    /**
     * Delete a pet.
     */
    $router->delete('/{petId}', 'PetController@delete');

});
