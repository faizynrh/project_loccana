<?php

namespace App\Http\Controllers\masterdata;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrincipalController extends Controller
{
    private function buildApiUrl($endpoint)
    {
        return Helpers::getApiUrl() . '/loccana/masterdata/partner/1.0.0/partner' . $endpoint;
    }
    private function ajaxprincipal(Request $request)
    {
        try {
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/lists');

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

            if (!empty($search)) {
                $requestbody['search'] = $search;
            }

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

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            return $this->ajaxprincipal($request);
        }
        return view('masterdata.principal.index');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function create()
    {
        $companyid = 2;
        $partnerurl = Helpers::getApiUrl() . '/loccana/masterdata/partner-type/1.0.0/partner-types/list-select';
        $headers = Helpers::getHeaders();
        $coaurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/list-select/' . $companyid;
        $partnerResponse = Http::withHeaders($headers)->get($partnerurl);
        $coaResponse = Http::withHeaders($headers)->get($coaurl);
        if ($partnerResponse->successful() && $coaResponse->successful()) {
            $partnerTypes = $partnerResponse->json();
            $coaTypes = $coaResponse->json();
            return view('masterdata.principal.add', compact('partnerTypes', 'coaTypes'));
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
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/');
            $data = [
                'name' => $request->input('nama'),
                'partner_type_id' => $request->input('partner_type_id'),
                'contact_info' => $request->input('contact_info'),
                'chart_of_account_id' => $request->input('chart_of_account_id'),
                'company_id' => 2,
                'is_customer' => false,
                'is_supplier' => true
            ];

            $apiResponse = Http::withHeaders($headers)->post($apiurl, $data);
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
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);
            $partnerurl = Helpers::getApiUrl() . '/loccana/masterdata/partner-type/1.0.0/partner-types/list-select';
            $coaurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/list-select/' . $companyid;

            $partnerResponse = Http::withHeaders($headers)->get($partnerurl);
            $coaResponse = Http::withHeaders($headers)->get($coaurl);
            $apiResponse = Http::withHeaders($headers)->get($apiurl);

            if ($apiResponse->successful()) {
                $principal = $apiResponse->json();

                if (isset($principal['data'])) {
                    if ($partnerResponse->successful() && $coaResponse->successful()) {
                        $partnerTypes = $partnerResponse->json();
                        $data = $apiResponse->json()['data'];
                        $coaTypes = $coaResponse->json();
                        return view('masterdata.principal.detail', ['principal' => $principal['data']], compact('partnerTypes', 'data', 'coaTypes'));
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
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);
            $partnerurl = Helpers::getApiUrl() . '/loccana/masterdata/partner-type/1.0.0/partner-types/list-select';
            $coaurl = Helpers::getApiUrl() . '/loccana/masterdata/coa/1.0.0/masterdata/coa/list-select/' . $companyid;
            $partnerResponse = Http::withHeaders($headers)->get($partnerurl);
            $coaResponse = Http::withHeaders($headers)->get($coaurl);
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
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);

            $data = [
                'name' => (string)$request->input('nama'),
                'partner_type_id' => $request->input('partner_type_id'),
                'contact_info' => $request->input('contact_info',),
                'chart_of_account_id' => $request->input('chart_of_account_id',),
                'company_id' => 2,
                'is_customer' => true,
                'is_supplier' => false
            ];

            $apiResponse = Http::withHeaders($headers)->put($apiurl, $data);
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
            $headers = Helpers::getHeaders();
            $apiurl = $this->buildApiUrl('/' . $id);
            $apiResponse = Http::withHeaders($headers)->delete($apiurl);
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
