<?php

namespace App\Http\Controllers\masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $username = "admin";
            $password = "admin";

            $apiResponse = getUser(env('USER_URL'), $username, $password);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                // dd($data);
                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $data['totalResults'], // Total user dalam sistem
                    'recordsFiltered' => count($data['Resources'] ?? []), // Jumlah hasil yang difilter
                    'data' => $data['Resources'] ?? [], // Data yang ditampilkan di tabel
                ]);
            }
            return response()->json([
                'error' => $apiResponse->json()['message'],
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function index(Request $request)
    {
        return view('masterdata.user.index');
    }
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
