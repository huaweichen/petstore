<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception $exception
     * @return JsonResponse
     */
    public function render($request, Exception $exception): JsonResponse
    {
        switch (true) {
            case $exception instanceof HttpException:
                $code = $exception->getStatusCode();
                $message = Response::$statusTexts[$code];
                return $this->errorResponse($message, $code);

            case $exception instanceof AuthorizationException:
            case $exception instanceof AuthenticationException:
                return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);

            case $exception instanceof ModelNotFoundException:
                return $this->errorResponse('Pet not found', Response::HTTP_NOT_FOUND);

            case $exception instanceof ValidationException:
                return $this->errorResponse('Invalid input', Response::HTTP_METHOD_NOT_ALLOWED);

            case $exception instanceof PetInvalidArgumentException:
                $message = $exception->getMessage();
                return $this->errorResponse($message, Response::HTTP_BAD_REQUEST);

            default:
                return $this->errorResponse('Error: Server Error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
