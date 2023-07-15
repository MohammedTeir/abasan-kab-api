<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], Response::HTTP_UNAUTHORIZED);
        }

            $requestedPath = parse_url(url()->current(), PHP_URL_PATH);
            if (strpos($requestedPath, 'dashboard') !== false) {
                return route('dashboard.showLogin');
            } else {
                return route('local');
            }

    }
}
