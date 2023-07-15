<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('api');


        if($user->address==null){
            return response()->json(['message' => 'يرجى اعادة المحاولة بعد اضافة العنوان الخاص بك'], Response::HTTP_NOT_ACCEPTABLE);
        }

        return $next($request);
    }
}
