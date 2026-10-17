<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthSiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('id_siswa')) {
            return redirect()->route('login.siswa')->withErrors(['msg' => 'Silakan login terlebih dahulu!']);
        }
        return $next($request);
    }
}
