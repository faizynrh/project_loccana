<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Ambil length dan start
            $length = $request->input('length');
            $start = $request->input('start');

            // Log untuk debugging
            // Log::info('DataTables Request', [
            //     'length' => $length,
            //     'start' => $start,
            //     'all_parameters' => $request->all() // Log semua parameter
            // ]);

            // Kembalikan response JSON dengan informasi lengkap
            return view('masterdata.user.user');
            // return response()->json([
            //     'length' => $length ?? null,
            //     'start' => $start ?? null,
            //     'message' => 'Data retrieved successfully',
            //     'connection_status' => 'connected'
            // ]);
        } catch (\Exception $e) {
            Log::error('Error in index method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
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
