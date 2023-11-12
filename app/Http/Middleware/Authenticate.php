<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        Log::info('Redirecting to login from Authenticate middleware');
        Log::info($request->headers);
        //401を返す、フロント側でリダイレクトする
        // Log::info($request->expectsJson());
        return $request->expectsJson() ? response()->json(['message' => 'Unauthenticated.'], 401) : route('login');
    }
}