<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
         $role = implode(', ', $user->getRoleNames()->toArray());
        // Check if the user has one of the specified roles
        if ($user && $role) {
            return $next($request);
        }
        
        // Redirect or abort if the user does not have the required role
        return redirect()->route('unauthorized'); // Replace 'unauthorized' with your actual unauthorized route
    }
}
