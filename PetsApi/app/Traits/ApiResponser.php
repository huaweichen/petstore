<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponser
{
    /**
     * Success response.
     *
     * @param mixed $details
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($details, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json($details, $code);
    }

    /**
     * Error response.
     *
     * @param mixed $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, int $code): JsonResponse
    {
        return response()->json(['code' => $code, 'type' => 'error', 'message' => $message], $code);
    }

}
