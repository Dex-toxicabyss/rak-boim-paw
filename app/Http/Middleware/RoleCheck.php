<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan oleh Pemilik.',
            ]);
        }

        if (!in_array(auth()->user()->role, $roles, true)) {
            abort(403, 'Akses ditolak: peran Anda tidak memiliki izin untuk aksi ini.');
        }

        return $next($request);
    }
}
