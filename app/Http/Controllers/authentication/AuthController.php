<?php

namespace App\Http\Controllers\authentication;

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
        $scope = 'openid profile roles user:read user:create user:update user:detail user:delete';
        $encoded_scope = urlencode($scope);

        $auth_url = env('AUTH_URL')
            . $client_id . '&scope=' . $encoded_scope . '&redirect_uri=' . $encoded_redirect_uri;


        $client = new Client(['verify' => false]);

        return redirect()->away($auth_url);
    }

    public function handleCallback(Request $request)
    {
        $client_id = env('IS_CLIENT_ID');
        $client_secret = env('IS_CLIENT_SECRET');
        $redirect_uri = route('oauth.callback');
        $tokenUrl = env('IS_TOKEN_URL');

        $authorizationCode = $request->query('code');

        if (!$authorizationCode) {
            return redirect('/')->with('error', 'No authorization code received');
        }

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
                Session::put('access_token', $accessToken);
                Session::put('id_token', $idToken);

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
                    $request->session()->put([
                        'user_info' => $userInfo,
                        'given_name' => $given_name,
                        'roles' => $roles,
                        'scope' => $scope,
                    ]);

                    return redirect()->route('dashboard-dev');
                } else {
                    return response('Error: Invalid ID token format.', 400);
                }
            } else {
                return response('Error: No ID token received.', 400);
            }
        } catch (RequestException $e) {
            $responseBody = $e->getResponse() ? (string) $e->getResponse()->getBody() : 'No response';
            return response('Error: ' . $e->getMessage() . "<br>Response: " . $responseBody, 500);
        }
    }

    public function logout(Request $request)
    {
        $idToken = Session::get('id_token');

        Session::flush();

        $client_id = env('IS_CLIENT_ID');
        $redirect_uri = route('oauth.callback');
        $logoutUrl = env('IS_LOGOUT_URL');

        $logoutRedirect = $idToken
            ? $logoutUrl . '?id_token_hint=' . urlencode($idToken) . '&post_logout_redirect_uri=' . urlencode($redirect_uri)
            : $redirect_uri;

        return Redirect::to($logoutRedirect);
    }
}
