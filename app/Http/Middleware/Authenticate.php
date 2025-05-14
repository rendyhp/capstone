<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (Auth::check() && Auth::user()->deleted_at !== null) {
            Auth::logout(); // force logout
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return route('login');
        }

        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
