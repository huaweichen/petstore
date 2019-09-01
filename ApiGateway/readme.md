### Requirement

1. PHP >= 7.1.3

1. OpenSSL PHP Extension

1. PDO PHP Extension

1. SQLITE PHP Extension

1. Mbstring PHP Extension

1. `Composer` installed

### Quick start

1. Copy `env.example` to `env`:
   
    1. Set `APP_KEY` with a random 32 length string.
    
    1. Set `API_KEY` for `ApiGateway` authentication.
    
    1. Set `PET_SERVICE_BASE_URL` to allow `ApiGateway` to point to.
    
    1. Set `PET_API_KEY` for `PetApi` authentication. 
    
    ```apacheconfig
    APP_KEY=2zmuMhGe1zuWc88rxzQjyKTSk3vqglyD
    API_KEY=special-key
    PET_SERVICE_BASE_URL=localhost:8081
    PET_API_KEY=special-key
    ```
1. Use `api_key: 'special-key'` in request header.

1. Change directory to `ApiGateway` folder and run `composer install` then start PHP server with `php -S localhost:8082 -t ./public`. So the url for `ApiGateway` is `http://localhost:8082`.

1. `ApiGateway` endpoints:

    Verb | Path | Description 
    --- | --- | ---
    POST   | /pet | Add a new pet to the store
    GET    | /pet/{petId} | Find a pet by {petId}
    POST   | /pet/{petId} | Update a pet information by {petId}
    DELETE | /pet/{petId} | Delete a pet

