<?php

namespace App\Http\Controllers\masterdata;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrincipalController extends Controller
{
    private function urlSelect()
    {
        return [
            'partnerurl' => env('API_URL') . '/loccana/masterdata/partner-type/1.0.0/partner-types/list-select',
            'coaurl' => env('API_URL') . '/loccana/masterdata/coa/1.0.0/masterdata/coa/list-select'
        ];
    }
    public function ajaxprincipal(Request $request)
    {
        try {
            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $search = $request->input('search.value', '');

            $requestbody = [
                'search' => '',
                'limit' => $length,
                'offset' => $start,
                'company_id' => 2,
                'is_customer' => false,
                'is_supplier' => true
            ];
            $apiResponse = storeApi(env('PRINCIPAL_URL') . '/lists', $requestbody);

            if (!empty($search)) {
                $requestbody['search'] = $search;
            }


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
                'error' => 'Failed to fetch data',
            ], 500);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }

    public function index()
    {
        //
        return view('masterdata.principal.index');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
        $companyid = 2;
        $partnerResponse = fectApi(env('LIST_PARTNER'));
        $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
        if ($partnerResponse->successful() && $coaResponse->successful()) {
            $partner
                = json_decode($partnerResponse->body(), false);
            $coa =
                json_decode($coaResponse->body(), false);
            return view('masterdata.principal.ajax.add', compact('partner', 'coa'));
        } else {
            $errors = [];
            if (!$coaResponse->successful()) {
                $errors[] = $coaResponse->json()['message'];
            }
            if (!$partnerResponse->successful()) {
                $errors[] = $partnerResponse->json()['message'];
            }
            return back()->withErrors($errors);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = [
                'name' => $request->input('nama'),
                'partner_type_id' => $request->input('partner_type_id'),
                'contact_info' => $request->input('contact_info'),
                'chart_of_account_id' => $request->input('chart_of_account_id'),
                'company_id' => 2,
                'is_customer' => false,
                'is_supplier' => true
            ];

            $apiResponse = storeApi(env('PRINCIPAL_URL') . '/', $data);
            $responseData = $apiResponse->json();
            if ($apiResponse->successful()) {
                return redirect()->route('principal.index')
                    ->with('success', $responseData['message']);
            } else {
                return back()->withErrors(
                    $responseData['message']
                );
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        try {
            $companyid = 2;
            $partnerResponse = fectApi(env('LIST_PARTNER'));
            $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
            $apiResponse = fectApi(env('PRINCIPAL_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                $principal = $apiResponse->json();

                if (isset($principal['data'])) {
                    if ($partnerResponse->successful() && $coaResponse->successful()) {
                        $partnerTypes = json_decode($apiResponse->getBody()->getContents());
                        $data = $apiResponse->json()['data'];
                        $coaTypes = $coaResponse->json();
                        return view('masterdata.principal.ajax.detail', ['principal' => $principal['data']], compact('partnerTypes', 'data', 'coaTypes'));
                    } else {
                        return back()->withErrors($apiResponse->json()['message']);
                    }
                } else {
                    return back()->withErrors($apiResponse->json()['message']);
                }
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
        try {
            $companyid = 2;
            $apiurl = $this->buildApiUrl('/' . $id);
            $partnerResponse = fectApi(env('LIST_PARTNER'));
            $coaResponse = fectApi(env('LIST_COA') . '/' . $companyid);
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $principal = $apiResponse->json();

                if (isset($principal['data'])) {
                    if ($partnerResponse->successful() && $coaResponse->successful()) {
                        $partnerTypes = $partnerResponse->json();
                        $data = $apiResponse->json()['data'];
                        $coaTypes = $coaResponse->json();
                        return view('masterdata.principal.edit', ['principal' => $principal['data']], compact('partnerTypes', 'data', 'coaTypes'));
                    } else {
                        return back()->withErrors($apiResponse->json()['message']);
                    }
                } else {
                    return back()->withErrors($apiResponse->json()['message']);
                }
            } else {
                return back()->withErrors($apiResponse->json()['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        try {

            $data = [
                'name' => (string) $request->input('nama'),
                'partner_type_id' => $request->input('partner_type_id'),
                'contact_info' => $request->input('contact_info',),
                'chart_of_account_id' => $request->input('chart_of_account_id',),
                'company_id' => 2,
                'is_customer' => true,
                'is_supplier' => false
            ];
            $apiResponse = updateApi(env('PRINCIPAL_URL' . '/' . $id), $data);
            if ($apiResponse->successful()) {
                return redirect()->route('principal.index')->with('success', $apiResponse->json()['message']);
            } else {
                return back()->withErrors('Gagal memperbarui data Principal: ' . $apiResponse->status());
            }
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $apiResponse = deleteApi(env('PRINCIPAL_URL') . '/' . $id);

            if ($apiResponse->successful()) {
                return redirect()->route('principal.index')
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
