<?php

namespace App\Http\Controllers;

use App\Helpers\Services\SocialAccountService;
use App\SocialAccount;
use App\User;
use Socialite;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    public function redirect(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        $loginUrl = $fb->getLoginUrl(['email']);
        return redirect()->to($loginUrl);
    }
    public function callback(\SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
    {
        try {
            $token = $fb->getAccessTokenFromRedirect();
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
        if (!$token) {
            $helper = $fb->getRedirectLoginHelper();

            if (!$helper->getError()) {
                abort(403, 'Unauthorized action');
            }
            dd(
                $helper->getError(),
                $helper->getErrorCode(),
                $helper->getErrorReason(),
                $helper->getErrorDescription()
            );
        }
        if (!$token->isLongLived()) {
            $oauthClient = $fb->getOAuth2Client();
            try {
                $token = $oauthClient->getLongLivedAccessToken($token);
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                dd($e->getMessage());
            }
        }
        $fb->setDefaultAccessToken($token);
        try {
            $response = $fb->get('/me?fields=id,name,email');
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
        $userFacebook = $response->getGraphUser();
        if (!isset($userFacebook['email'])) {
            flash()->overlay('Maaf facebook Anda terdaftar dengan nomor handphone.
                Silahkan perbaharui email facebook Anda sesuai dengan email
								yang terdaftar di Smart In Pays.', 'INFO');
            return redirect()->to('/login');
        }
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($userFacebook['id'])
            ->first();
        if ($account) {
            $account->access_token = $token;
            $account->save();
            auth()->login($account->user);
            return redirect()->route('index');
        }
        $user = User::whereEmail($userFacebook['email'])->first();
        if ($user) {
            $user->socialAccount()->create([
                'provider_user_id' => $userFacebook['id'],
                'provider' => 'facebook',
                'access_token' => $token,
            ]);
            auth()->login($user);
            return redirect()->route('index');
        }
        flash()->overlay('Email facebook Anda tidak terdaftar di Smart In Pays');
        return redirect()->to('/login');
    }
    public function postToFacebook(Request $request)
    {
        $dataAppFacebook = [
                'app_id'=>env('FACEBOOK_APP_ID'),
                'app_secret'=>env('FACEBOOK_APP_SECRET'),
                'default_graph_version'=>'v2.1'
            ];
        $user = $request->user();
        $socialAccount = $user->socialAccount()->whereProvider('facebook')->first();
        if ($socialAccount) {
            $fb = new \Facebook\Facebook($dataAppFacebook);
            $linkData = [
                          'link' => 'https://smartinpays.com',
                          'message' => 'Saya baru saja membeli tiket pesawat di Smart In Pays ! Pakai SIP Pasti SIP..',
                      ];

            //$token='EAAbJtWK1hPsBAO2HZAAujnrsPPLrf9QA25KRdyGaUX7uX4ZCZC8ZAakrUQ0VySJlFo7sOPCZCXaO6p6VIo6IcYJDox1ruPrhh12Fyq8ctKsBwARMQQndkJjhaPUleGXIAk6HpWTNOgB4heXlM6Tg8jomTDjw0DbPHYef7XDNTpOkQ7SXX7rgl6yBTaS3sWPoZD';
            try {
                $response = $fb->post('/me/feed', $linkData, $socialAccount->access_token);
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                //return response()->json(['message'=>'Graph returned an error: ' . $e->getMessage()], 400);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                return response()->json(['message'=>'Facebook SDK returned an error: ' . $e->getMessage()], 400);
            }

            $graphNode = $response->getGraphNode();
            return $graphNode;
        }
        return response()->json(['message'=>'Your account not integrated with facebook'], 404);
    }
    // public function callback(SocialAccountService $service)
    // {
    //     $user = $service->getUserForFacebook(Socialite::driver('facebook')->user());
    //     if ($user->id == 1) {
    //         flash()->overlay('Email facebook Anda tidak terdaftar di Smart In Pays');
    //         return redirect()->to('/login');
    //     }
    //     auth()->login($user);
    //     return redirect()->route('index');
    // }
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callbackGoogle(SocialAccountService $service)
    {
        $user = $service->getUserForGoogle(Socialite::driver('google')->user());
        if ($user->id == 1) {
            flash()->overlay('Email google Anda tidak terdaftar di Smart In Pays');
            return redirect()->to('/login');
        }
        auth()->login($user);
        return redirect()->route('index');
    }
}
