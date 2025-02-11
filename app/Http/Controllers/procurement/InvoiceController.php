<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $status = $request->input('status', 0);
            $year = $request->input('year', 0);
            $month = $request->input('month', 0);
            $search = $request->input('search.value') ?? '';
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);

            $requestbody1 = [
                'status' => "semua",
                'year' => $year,
                'month' => $month,
                'search' => $search,
                'company_id' => 2,
                'limit' => $length,
                'offset' => $start,
            ];

            $requestbody2 = [
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'company_id' => 2,
            ];
            $apiResponse = storeApi(env('INVOICE_URL') . '/list', $requestbody1);
            $mtdResponse = storeApi(env('INVOICE_URL') . '/mtd', $requestbody2);
            if ($apiResponse->successful() && $mtdResponse->successful()) {
                $data = $apiResponse->json();
                $mtd = $mtdResponse->json();
                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                    'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                    'data' => $data['data']['table'] ?? [],
                    'mtd' => $mtd['data'] ?? [],
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
    public function index()
    {
        return view('procurement.invoice.index');
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
    public function show($id)
    {
        try {
            $apiResponse = fectApi(env('INVOICE_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $data = json_decode($apiResponse->body());
                // dd($data);
                return view('procurement.invoice.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
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
