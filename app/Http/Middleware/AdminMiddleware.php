<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            // If user is not admin, redirect to home with error
            return redirect('/')->with('error', 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}