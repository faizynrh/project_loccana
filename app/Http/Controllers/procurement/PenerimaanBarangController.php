<?php

namespace App\Http\Controllers\procurement;

use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class PenerimaanBarangController extends Controller
{
    private function buildApiUrl($endpoint)
    {
        return Helpers::getApiUrl() . '/loccana/itemreceipt/1.0.0/item_receipt/1.0.0' . $endpoint;
    }

    private function urlSelect($id)
    {
        return [
            'po' => Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/list-select/' . $id,
            'gudang' => Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/list-select/' . $id,
            'podetail' => Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/' . $id
        ];
    }

    private function ajax(Request $request)
    {
        try {
            $headers = Helpers::getHeaders();
            $month = $request->input('month');
            $year = $request->input('year');
            $length = $request->input('length');
            $start = $request->input('start');
            $search = $request->input('search.value') ?? '';

            $requestbody = [
                'search' => $search,
                'month' => $month,
                'year' => $year,
                'limit' => $length,
                'offset' => $start,
                'company_id' => 0,
            ];

            $apiurl = $this->buildApiUrl('/lists');
            $mtdurl = $this->buildApiUrl('/mtd');

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $requestbody);
            $mtdResponse = Http::withHeaders($headers)->post($mtdurl, $requestbody);

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
                'error' => $apiResponse->json()['message']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ajax($request);
        }
        return view('procurement.penerimaanbarang.index');
    }
    public function getPoDetails(Request $request, $po_id)
    {
        $headers = Helpers::getHeaders();
        $apiurl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/'  . $po_id;

        try {
            $apiResponse = Http::withHeaders($headers)->get($apiurl);
            $items = [];
            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                $items = [];
                foreach ($data as $item) {
                    $items[] = [
                        'item_id' => $item['item_id'],
                        'item_code' => $item['item_code'],
                        'base_qty' => $item['base_qty'],
                        'qty_balance' => $item['qty_balance'],
                        'qty' => $item['qty'],
                        'item_description' => $item['item_description'],
                        'warehouse_id' => $item['warehouse_id'],
                    ];
                }
                return response()->json([
                    'id_po' => $data[0]['id_po'],
                    'order_date' => $data[0]['order_date'],
                    'partner_name' => $data[0]['partner_name'],
                    'address' => $data[0]['address'],
                    'description' => $data[0]['description'],
                    'phone' => $data[0]['phone'],
                    'fax' => $data[0]['fax'],
                    'warehouse_id' => $data[0]['warehouse_id'],
                    'items' => $items
                ]);
            }
            return response()->json(['error' => $apiResponse->json()['message']]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function create()
    {
        $company_id = 2;
        $headers = Helpers::getHeaders();

        $pourl = $this->urlSelect($company_id)['po'];
        $gudangurl = $this->urlSelect($company_id)['gudang'];

        $pourl = Helpers::getApiUrl() . '/loccana/po/1.0.0/purchase-order/list-select/' . $company_id;
        $gudangurl = Helpers::getApiUrl() . '/masterdata/warehouse/1.0.0/warehouse/list-select/' . $company_id;

        $poResponse = Http::withHeaders($headers)->get($pourl);
        $gudangResponse = Http::withHeaders($headers)->get($gudangurl);
        if ($poResponse->successful() && $gudangResponse->successful()) {
            $po = $poResponse->json()['data'];
            $gudang = $gudangResponse->json()['data'];
            return view('procurement.penerimaanbarang.add', compact('po', 'gudang'));
        } else {
            $errors = [];
            if (!$poResponse->successful()) {
                $errors[] = $poResponse->json()['message'];
            }
            if (!$gudangResponse->successful()) {
                $errors[] = $gudangResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function store(Request $request)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/');

            $dataitems = [];
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    $dataitems[] = [
                        'item_id' => $item['item_id'],
                        'quantity_rejected' => $item['qty_reject'],
                        'quantity_received' => $item['qty_received'],
                        'notes' => $item['note'],
                        'qty_titip' => $item['qty_titip'],
                        'qty_diskon' => $item['discount'],
                        'qty_bonus' => $item['qty_bonus'],
                        'warehouse_id' => $item['warehouse_id'],
                    ];
                }
            }

            $data = [
                'purchase_order_id' => $request->purchase_order_id,
                'do_number' => $request->do_number,
                'receipt_date' => $request->receipt_date,
                'shipment_info' => $request->shipment_info,
                'plate_number' => $request->plate_number,
                'received_by' => $request->input('received_by', 0),
                'status' => "received",
                'company_id' => $request->input('company_id',  2),
                'is_deleted' => 'true',
                'items' => $dataitems
            ];

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')
                    ->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('procurement.penerimaanbarang.detail', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);

            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $data = $apiResponse->json()['data'];
                return view('procurement.penerimaanbarang.edit', compact('data'));
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);

            $items = [];
            if ($request->has('item_id')) {
                foreach ($request->input('item_id') as $index => $itemId) {
                    $items[] = [
                        'item_id' => $itemId,
                        'quantity_received' => $request->input('quantity_received')[$index],
                        // 'quantity_received_old' => $request->input('quantity_received')[$index],
                        //tidak ada data
                        // 'quantity_rejected' => $request->input('quantity_rejected')[$index],
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
            $data = [
                'do_number' => $request->do_number,
                'receipt_date' => $request->receipt_date,
                'shipment_info' => $request->shipment_info,
                'plate_number' => $request->plate_number,
                'received_by' => $request->input('received_by', 0),
                'status' => "received",
                'items' => $items,
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);

            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
            if ($apiResponse->successful()) {
                return redirect()->route('penerimaan_barang.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
