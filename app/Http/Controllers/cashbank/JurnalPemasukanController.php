<?php

namespace App\Http\Controllers\cashbank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JurnalPemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function ajaxpemasukan(Request $request)
    {
        $search = $request->input('search.value') ?? '';
        $month = $request->input('month', 11);
        $year = $request->input('year', 0);
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);

        $requestbody = [
            'search' => '',
            'month' => $month,
            'year' => $year,
            'limit' => $length,
            'offset' => $start,
        ];

        if (!empty($search)) {
            $requestbody['search'] = $search;
        }

        $apiResponse = storeApi(env('JURNAL_MASUK_URL') . '/list', $requestbody);

        if ($request->ajax()) {
            try {
                if ($apiResponse->successful()) {
                    $data = $apiResponse->json();
                    return response()->json([
                        'draw' => $request->input('draw'),
                        'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                        'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                        'data' => $data['data']['table'] ?? [],
                        // 'mtd' => $mtd['data'] ?? [],
                    ]);
                }
                return response()->json(['error' => 'Failed to fetch data'], 500);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function index()
    {
        return view('cashbank.jurnalpemasukan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyid = 2;
        $requestbody = [
            'company_id' => $companyid
        ];
        $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
        if ($coaResponse->successful()) {
            $coa = $coaResponse->json()['data'];
            return view('cashbank.jurnalpemasukan.add', compact('coa'));
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
        try {
            $apiResponse = deleteApi(env('JURNAL_MASUK_URL') . '/' . $id);
            if ($apiResponse->successful()) {
                return redirect()->route('pemasukan.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors(
                    $apiResponse->json()['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
