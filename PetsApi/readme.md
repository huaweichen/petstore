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

    1. Set `API_KEY` for authentication.

    ```apacheconfig
    APP_KEY=AxYtuO8YnmfKIHmILoaHXrHqpMP6LsuC
    API_KEY=special-key
    ```

1. Create a new file `database.sqlite` under `PetsApi/database` for lightweight file based database.

1. Change directory to `PetsApi` folder and run `composer install` then start PHP server with `php -S localhost:8081 -t ./public`. So the url for `ApiGateway` is `http://localhost:8081`.

1. Use `api_key: 'special-key'` in request header.

1. `PetsApi` endpoints:

    Verb | Path | Description 
    --- | --- | ---
    POST   | /pet | Add a new pet to the store
    GET    | /pet/{petId} | Find a pet by {petId}
    POST   | /pet/{petId} | Update a pet information by {petId}
    DELETE | /pet/{petId} | Delete a pet

1. Initialize database `php artisan migrate` and `php artisan db:seed`.
