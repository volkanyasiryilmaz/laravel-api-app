<?php

namespace App\Http\Middleware;

use Closure;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('api-key') !== env('REQUEST_KEY')) {
            return responder()->error(400)->respond(400);
        }
        return $next($request);
    }
}
