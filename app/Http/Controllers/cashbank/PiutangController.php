<?php

namespace App\Http\Controllers\cashbank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PiutangController extends Controller
{
    public function index()
    {
        return view('cashbank.piutang.index');
    }

    public function pembayaran()
    {
        return view('cashbank.piutang.pembayaran.index');
    }

    public function giro()
    {
        return view('cashbank.piutang.giro.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
