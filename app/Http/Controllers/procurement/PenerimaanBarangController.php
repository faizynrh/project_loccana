<?php

namespace App\Http\Controllers\procurement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PenerimaanBarangController extends Controller
{
    private function getAccessToken()
    {
        $tokenurl = env('API_TOKEN_URL');
        $clientid = env('API_CLIENT_ID');
        $clientsecret = env('API_CLIENT_SECRET');

        $tokenResponse = Http::asForm()->post($tokenurl, [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
        ]);

        if (!$tokenResponse->successful()) {
            throw new \Exception('Failed to fetch access token');
        }

        return $tokenResponse->json()['access_token'];
    }

    private function getHeaders()
    {
        $accessToken = $this->getAccessToken();
        return [
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json'
        ];
    }

    private function getApiUrl()
    {
        $apiurl = env('API_URL');
        return $apiurl;
    }
    public function index(Request $request)
    {
        $headers = $this->getHeaders();
        $month = $request->input('month', 0);
        $year = $request->input('year', 0);
        $length = $request->input('length', 10);
        $start = $request->input('start', 0);
        $search = $request->input('search.value', '');

        $requestbody = [
            'month' => $month,
            'year' => $year,
            'limit' => $length,
            'offset' => $start,
            'company_id' => 0,
        ];

        if (!empty($search)) {
            $requestbody['search'] = $search;
        }

        $apiurl = $this->getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/lists';
        $mtdurl = $this->getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/mtd';

        if ($request->ajax()) {
            try {
                $apiResponse = Http::withHeaders($headers)->post($apiurl, $requestbody);

                if ($apiResponse->successful()) {
                    $data = $apiResponse->json();
                    return response()->json([
                        'draw' => $request->input('draw'),
                        'recordsTotal' => $data['data']['jumlah_filter'] ?? 0,
                        'recordsFiltered' => $data['data']['jumlah'] ?? 0,
                        'data' => $data['data']['table'] ?? [],
                    ]);
                }
                return response()->json(['error' => 'Failed to fetch data'], 500);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        $mtdResponse = Http::withHeaders($headers)->post($mtdurl, $requestbody);

        if ($mtdResponse->successful()) {
            $data = $mtdResponse->json()['data'];
            return view('procurement.penerimaanbarang.penerimaan', compact('data'));
        }

        return view('procurement.penerimaanbarang.penerimaan');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $headers = $this->getHeaders();
        $pourl = $this->getApiUrl() . '/loccana/po/1.0.0/purchase-order/list-select';
        $poResponse = Http::withHeaders($headers)->get($pourl);

        if ($poResponse->successful()) {
            $po = $poResponse->json()['data'];
            return view('procurement.penerimaanbarang.add', compact('po'));
        } else {
            return back()->withErrors('Gagal mengambil data dari API.');
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
    public function show($id)
    {
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
                return view('procurement.penerimaanbarang.detail', compact('data'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
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
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                // dd($data);
                return view('procurement.penerimaanbarang.edit', compact('data'));
            } else {
                return back()->withErrors('Gagal mengambil data item: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // dd($request->all());
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            $items = [];
            if ($request->has('item_id')) {
                foreach ($request->input('item_id') as $index => $itemId) {
                    $items[] = [
                        'item_id' => $itemId,
                        'quantity_received' => $request->input('quantity_received')[$index],
                        // 'quantity_received_old' => $request->input('quantity_received')[$index],
                        'notes' => $request->input('notes')[$index],
                        'qty_titip' => $request->input('qty_titip')[$index],
                        // 'qty_titip_old' => $request->input('qty_titip')[$index],
                        'qty_diskon' => $request->input('qty_diskon')[$index],
                        'qty_bonus' => $request->input('qty_bonus')[$index],
                        // 'qty_bonus_old' => $request->input('qty_bonus')[$index],
                        'warehouse_id' => $request->input('warehouse_id')[$index],
                    ];
                }
            }
            // dd($items);
            $data = [
                'do_number' => $request->do_number,
                'receipt_date' => $request->receipt_date,
                'shipment_info' => $request->shipment_info,
                'plate_number' => $request->plate_number,
                'received_by' => $request->input('received_by', 0),
                'status' => "received",
                'items' => $items,
            ];
            // dd($data);
            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);
            dd([
                'apiResponse' => $apiResponse->json(),
                'data' => $data
            ]);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang')->with('success', 'Data berhasil diperbarui!');
            } else {
                return back()->withErrors('Gagal memperbarui data: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $headers = $this->getHeaders();
            $apiurl = $this->getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0/' . $id;
            // dd($id);
            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang')
                    ->with('success', 'Data Penerimaan Barang Berhasil Dihapus!');
            } else {
                return back()->withErrors(
                    'Gagal menghapus data: ' . $apiResponse->body()
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
