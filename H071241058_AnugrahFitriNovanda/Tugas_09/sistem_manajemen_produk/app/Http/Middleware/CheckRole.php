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
     * @param  ...$roles (Ini akan menerima peran, misal: 'Admin', 'Staf Produk')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        foreach ($roles as $role) {
            if ($user->role->name == $role) {
                return $next($request);
            }
        }

        abort(403, 'AKSES DITOLAK: Anda tidak memiliki izin untuk halaman ini.');
    }
}