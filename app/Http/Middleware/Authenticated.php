<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Redirect;

class Authenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Mengecek apakah ada access_token di session
        if (!Session::has('access_token')) {
            // Jika tidak ada access_token, redirect ke halaman login
            return redirect()->route('home'); // Ganti dengan rute login yang sesuai
        }

        return $next($request); // Lanjutkan permintaan jika sudah terautentikasi
    }
}
