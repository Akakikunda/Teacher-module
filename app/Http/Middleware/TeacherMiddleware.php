<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the logged-in user is a teacher
        if (Auth::check() && Auth::user()->role === 'teacher') {
            return $next($request);
        }

        // Redirect if not a teacher
        return redirect('/dashboard')->with('error', 'Access Denied. Teachers Only!');
    }
}


