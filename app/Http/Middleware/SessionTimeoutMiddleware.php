<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\authentication\AuthController;
// use App\Http\Controllers\AuthController;

class SessionTimeoutMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $timeout = 5 * 60; // 30 menit
        $lastActivity = Session::get('last_activity');

        if ($lastActivity && (time() - $lastActivity > $timeout)) {
            $authController = app(AuthController::class);
            return $authController->logout($request);
        }

        Session::put('last_activity', time());

        return $next($request);
    }
}
