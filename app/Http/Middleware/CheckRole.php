<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        // Split roles by | to support multiple roles (e.g., 'admin|cashier')
        $roleList = explode('|', $roles);
        
        if (!in_array($user->role, $roleList)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
