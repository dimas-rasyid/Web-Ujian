<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthGuru
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah session guru sudah ada
        if (!session()->has('id_guru')) {
            return redirect()->route('login.guru')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}