<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and is student
        if (!auth()->check() || !auth()->user()->isStudent()) {
            // If user is not student, redirect to home with error
            return redirect('/')->with('error', 'Unauthorized access. Student account required.');
        }

        return $next($request);
    }
}