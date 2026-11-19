<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Jika tidak ditentukan atau role cocok
        if (empty($roles) || in_array($user->role, $roles)) {
            return $next($request);
        }

        return abort(403, 'Akses terbatas: Anda tidak memiliki wewenang untuk membuka modul ini.');
    }
}
