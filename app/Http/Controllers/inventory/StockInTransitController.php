<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockInTransitController extends Controller
{
    public function ajax(Request $request)
    {
        try {
            $start_date = $request->input('start_date', 0);
            $end_date = $request->input('end_date', 0);
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'company_id' => 0,
                'limit' => $length,
                'offset' => $start,
            ];
            $apiResponse = storeApi(env('STOCK_IN_TRANSIT_URL') . '/lists', $requestbody);
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
        return view('inventory.stockintransit.index');
    }

    public function create()
    {
        $company_id = 2;
        $supplier = "false";
        $customer = "true";
        $requestbody = [
            'company_id' => $company_id,
        ];
        $partnerResponse = fectApi(env('LIST_PARTNER') . '/' . $company_id . '/' . $supplier . '/' . $customer);
        $itemResponse = storeApi(env('LIST_ITEMS'), $requestbody);
        if ($partnerResponse->successful()) {
            $partner = json_decode($partnerResponse->body());
            $item = json_decode($itemResponse->body());
            dd($item);
            return view('inventory.stockintransit.add', compact('partner', ));
        } else {
            return back()->withErrors($partnerResponse->json()['message']);
        }
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
