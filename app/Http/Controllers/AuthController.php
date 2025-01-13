<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

use GuzzleHttp\Exception\RequestException;


class AuthController extends Controller
{
    public function redirectToIdentityServer()
    {
        $client_id = env('IS_CLIENT_ID');
        $client_secret = env('IS_CLIENT_SECRET');
        $redirect_uri = route('oauth.callback');

        $encoded_redirect_uri = urlencode($redirect_uri);
        // $scope = 'openid email phone profile roles';
        $scope = 'openid profile roles user:read user:create user:update user:detail user:delete';
        // dd($scope);
        $encoded_scope = urlencode($scope);

        // URL otorisasi WSO2
        // https://172.18.1.111:9443/oauth2/authorize
        $auth_url = 'https://172.18.1.111:9443/oauth2/authorize?response_type=code&client_id='
            . $client_id . '&scope=' . $encoded_scope . '&redirect_uri=' . $encoded_redirect_uri;

        // dd($auth_url);

        $client = new Client(['verify' => false]);

        // Redirect ke URL WSO2 untuk autentikasi
        return redirect()->away($auth_url);
    }

    public function handleCallback(Request $request)
    {
        $client_id = env('IS_CLIENT_ID');
        $client_secret = env('IS_CLIENT_SECRET');
        $redirect_uri = route('oauth.callback'); // Callback URI yang sudah diatur di route
        $tokenUrl = env('IS_TOKEN_URL'); // URL untuk menukar token

        $authorizationCode = $request->query('code'); // Authorization code dari query string

        if (!$authorizationCode) {
            return redirect('/')->with('error', 'No authorization code received');
        }

        // Menukar authorization code dengan access token dan id token
        $client = new Client(['verify' => false]);

        try {
            $response = $client->post($tokenUrl, [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $authorizationCode,
                    'redirect_uri' => $redirect_uri,
                ],
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode("$client_id:$client_secret"),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            $accessToken = $data['access_token'] ?? '';
            $idToken = $data['id_token'] ?? '';
            $scope = $data['scope'] ?? '';

            if ($idToken) {
                // Simpan access token dan id token ke session
                Session::put('access_token', $accessToken);
                Session::put('id_token', $idToken);

                // Proses decoding ID token untuk mendapatkan informasi user
                $tokenParts = explode('.', $idToken);
                if (count($tokenParts) === 3) {
                    $tokenPayload = $tokenParts[1];
                    $decodedPayload = base64_decode(str_replace(['-', '_'], ['+', '/'], $tokenPayload));
                    $jwtPayload = json_decode($decodedPayload, true);

                    $email = $jwtPayload['email'] ?? '';
                    $roles = $jwtPayload['roles'] ?? [];
                    $username = $jwtPayload['username'] ?? '';
                    $given_name = $jwtPayload['given_name'] ?? '';

                    if (!is_array($roles)) {
                        $roles = [$roles];
                    }

                    $userInfo = [
                        'username' => $username,
                        'roles' => $roles,
                        'email' => $email,
                    ];
                    // Simpan user info dan roles ke session
                    Session::put('user_info', $userInfo);
                    Session::put('given_name', $given_name);
                    Session::put('roles', $roles);
                    Session::put('scope', $scope);

                    // Redirect ke dashboard sesuai role
                    return redirect()->route('dashboard-dev');
                } else {
                    return response('Error: Invalid ID token format.', 400);
                }
            } else {
                return response('Error: No ID token received.', 400);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse() ? (string)$e->getResponse()->getBody() : 'No response';
            return response('Error: ' . $e->getMessage() . "<br>Response: " . $responseBody, 500);
        }
    }

    public function logout(Request $request)
    {
        $idToken = Session::get('id_token');

        // Hapus session
        Session::flush();

        $client_id = env('IS_CLIENT_ID');
        $redirect_uri = route('oauth.callback'); // URI untuk redirect setelah logout
        // https://172.18.1.111:9443/oidc/logout
        $logoutUrl = 'https://172.18.1.111:9443/oidc/logout';

        // Redirect ke URL logout WSO2 dengan ID token jika tersedia
        $logoutRedirect = $idToken
            ? $logoutUrl . '?id_token_hint=' . urlencode($idToken) . '&post_logout_redirect_uri=' . urlencode($redirect_uri)
            : $redirect_uri;

        return Redirect::to($logoutRedirect);
    }
}
