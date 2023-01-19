<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\OauthAccessToken;
// use App\OauthClient;
use App\OauthClientSecret;
use App\UserLocation;
use App\User;
// use App\Address;
// use App\UserReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiLocationsController extends Controller
{
    //
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;
    public function __construct(Request $request)
    {
//        if ($request->hasHeader('authorization')) {
//            $token = explode(' ', $request->header('authorization'));
//            $newTime = time() + 259200;
//            $accessToken = OauthAccessToken::find($token[1]);
//            $accessToken->expire_time = $newTime;
//            $accessToken->save();
//        }
//        if ($request->has('access_token')) {
//            $newTime = time() + 259200;
//            $accessToken = OauthAccessToken::find($request->access_token);
//            $accessToken->expire_time = $newTime;
//            $accessToken->save();
//        }
    }
    public function config(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'share_location' => 'required|numeric',
            'show_on_map' => 'required|numeric',
            'client_id' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors(),
                ],
            ], 400);
        }
        $oauthclientsecret =OauthClientSecret::where('client_id', '=', $request->client_id)->first();
        if ($oauthclientsecret === null) {
            $this->setStatusMessage('Client Id tidak ditemukan');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        if ($request->share_location !=="0" && $request->share_location !=="1") {
            $this->setStatusMessage('Value share location harus 0 atau 1. 0 = tidak, 1 = ya');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        if ($request->show_on_map !=="0" && $request->show_on_map !=="1") {
            $this->setStatusMessage('Value show on map harus 0 atau 1. 0 = tidak, 1 = ya');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        $user_id = $oauthclientsecret->user_id;
        $device_type = $oauthclientsecret->device_type;
        $user = User::find($user_id);
        $username = $user->username;
        $credentials = [
            'username' => $username,
            'password' => $request->password,
        ];
        $userLogin = Auth::once($credentials);
        if ($userLogin) {
            if ($user->user_location()->where('device', '=', $device_type)->first() !==null) {
                $location = UserLocation::where('user_id', '=', $user_id)->where('device', '=', $device_type)->first();
                // dd($location);
                DB::beginTransaction();
                try {
                    $location = UserLocation::where('user_id', '=', $user_id)->where('device', '=', $device_type)->update(['share_location' => $request->share_location]);
                    $map = UserLocation::where('user_id', '=', $user_id)->where('device', '=', $device_type)->update(['show_on_map' => $request->show_on_map]);
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->setStatusMessage('Error : ' . $e->getMessage());
                    return Response::json([
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ]);
                }
                DB::commit();
            } else {
                DB::beginTransaction();
                try {
                    $location = UserLocation::create([
                        'user_id' => $user_id,
                        'type_user_id' => $user->type_user_id,
                        'device' => $device_type,
                        'lat' => 0,
                        'lng' => 0,
                        'share_location' => $request->share_location,
                        'show_on_map' => $request->show_on_map,
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->setStatusMessage('Error : ' . $e->getMessage());
                    return Response::json([
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ]);
                }
                DB::commit();
            }
            $this->setStatusMessage('Success update location configuration.');
            return [
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
                'details' => [
                    'share_location' => $request->share_location,
                    'show_on_map' => $request->show_on_map,
                ],
            ];
        } else {
            $this->setStatusMessage('Password anda salah');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
    }
    public function proUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors(),
                ],
            ], 400);
        }
        //return $request->all();

        if ($request->lat == "0" || $request->lng == "0" || $request->lat == 0 || $request->lng == 0) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => 'GPS di perangkat Anda belum diaktifkan. Pastikan aplikasi SIP di izinkan untuk mengakses lokasi Anda',
                ],
            ], 400);
        }

        // $x = 1;
        // $users=null;
        // while (count($users) === 0 && $x<=5) {
        // $users = DB::select( DB::raw(
        //          "SELECT user_id,
        //          (6371 * acos(cos(radians(3.550425)) * cos(radians(lat)) * cos(radians(lng) - radians(186.623570)) + sin(radians(3.550425)) * sin(radians(lat))))
        //          AS distance
        //          FROM user_locations where type_user_id = 4
        //          HAVING distance < 5000*$x
        //          ORDER BY distance ASC
        //          LIMIT 20"));
        $users = DB::select(DB::raw(
              "SELECT user.user_id, user.show_on_map, user.lat, user.lng, user.distance
              FROM ( SELECT user_id, show_on_map, lat, lng,
              (6371 * acos(cos(radians($request->lat)) * cos(radians(lat)) * cos(radians(lng) - radians($request->lng)) + sin(radians($request->lat)) * sin(radians(lat))))
              AS distance
              FROM user_locations where type_user_id = 4 and share_location = 1
              HAVING distance < 300
              ORDER BY distance ASC
              LIMIT 200) AS user
              GROUP BY user.user_id
              ORDER BY user.distance ASC
              LIMIT 100"
              ));
//        $users = DB::select(DB::raw(
//            "SELECT user.user_id, user.lat, user.lng, user.distance
//              FROM ( SELECT user_id, lat, lng,
//              (6371 * acos(cos(radians($request->lat)) * cos(radians(lat)) * cos(radians(lng) - radians($request->lng)) + sin(radians($request->lat)) * sin(radians(lat))))
//              AS distance
//              FROM user_devices where user_type_id = 'pro'
//              HAVING distance < 500
//              ORDER BY distance ASC
//              LIMIT 200) AS user
//              GROUP BY user.user_id
//              ORDER BY user.distance ASC
//              LIMIT 100"
//        ));
        //     $x++;
        // }
        foreach ($users as $user) {
            $data = User::find($user->user_id);
            $user->name=$data->name;
//            $user->phone=$data->getTelephone();
//            $user->referral=$data->getReferral();
            $user->phone = $data->phone_number;
            $user->referral = $data->username;
//            if ($user->show_on_map === 0) {
//                $user->lat = null;
//                $user->lng = null;
//                $user->distance = null;
//                $user->distance_unit = 'KM';
//                $user->url_photo = null;
//            } else {
                $user->url_photo = "https://mysmartinpays.com/images/user/photo/default.jpg";
                if ($data->photo) {
                    $user->url_photo = $data->photo->url_photo;
                }
                $user->distance_unit = 'KM';
//            }
        }
        if (count($users) === 0) {
            $this->setStatusMessage("Tidak ada member disekitar lokasi Anda.");
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $this->setStatusMessage("Ada member disekitar lokasi Anda.");
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => $users,
        ]);
    }

    private function getCodeSuccess()
    {
        return $this->codeSuccess;
    }
    private function getCodeFailed()
    {
        return $this->codeFailed;
    }
    private function getConfirmSuccess()
    {
        return $this->confirmSuccess;
    }
    private function getConfirmFailed()
    {
        return $this->confirmFailed;
    }
    private function setStatusMessage($message)
    {
        (is_array($message) ? $this->statusMessage = $message : $this->statusMessage = array($message));
    }
    private function getStatusMessage()
    {
        return $this->statusMessage;
    }
}
