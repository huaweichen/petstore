<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate
{
    /**
     * Authenticate `api_key`.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('api_key') === env('API_KEY')) {
            return $next($request);
        }

        abort(Response::HTTP_UNAUTHORIZED);
    }
}
