<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowDashboard extends Controller
{
    public function showDashboard()
    {
        // dd('sada');
        // Misalnya, ambil data roles dari session atau dari suatu source
        $message = 'Welcome to Developer Dashboard';
        // dd($message);

        // dd($roles); // Jika Anda ingin men-debug roles, pastikan variabel $roles sudah didefinisikan

        return view('dashboard', compact('message'));
    }
}
