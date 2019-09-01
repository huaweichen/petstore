<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use GuzzleHttp\Exception\ClientException;
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
     * @inheritDoc
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param \Exception $exception
     * @return Response|JsonResponse
     */
    public function render($request, Exception $exception)
    {
        switch (true) {
            case $exception instanceof HttpException:
                $code = $exception->getStatusCode();
                $message = Response::$statusTexts[$code];

                return $this->errorResponse($message, $code);

            case $exception instanceof ModelNotFoundException:
                $model = class_basename($exception->getModel());
                $description = "{$model} not found";

                return $this->errorResponse($description, Response::HTTP_NOT_FOUND);

            case $exception instanceof AuthorizationException:
                return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);

            case $exception instanceof AuthenticationException:
                return $this->errorResponse($exception->getMessage(), Response::HTTP_UNAUTHORIZED);

            case $exception instanceof ValidationException:
                $error = $exception->validator->errors()->getMessages();

                return $this->errorResponse($error, Response::HTTP_UNPROCESSABLE_ENTITY);

            case $exception instanceof ClientException:
                $message = $exception->getResponse()->getBody()->getContents();
                $code = $exception->getCode();

                return $this->errorMessage($message, $code);

            default:
                if (env('APP_DEBUG', false)) {
                    return parent::render($request, $exception);
                }

                return $this->errorResponse('Unexpected error.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
