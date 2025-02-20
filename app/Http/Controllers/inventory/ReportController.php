<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $partner_id = $request->input('principal', 0);
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'partner_id' => $partner_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('REPORT_INV_URL'), $requestbody);
            if ($apiResponse->successful()) {
                $data = $apiResponse->json();
                return response()->json([
                    'draw' => $request->input('draw'),
                    'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                    'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                    'data' => $data['data']['table'] ?? [],
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
        $company_id = 2;
        $supplier = "true";
        $customer = "false";
        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $supplier . '/' . $customer);
        if ($partnerResponse->successful()) {
            $partner = json_decode($partnerResponse->body());
            return view('inventory.report.index', compact('partner'));
        }
        return view('inventory.report.index');
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
