<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Helpers\Products;
use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClient;
use App\OauthClientSecret;
use App\User;
use App\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use App\Helpers\SipSms;
use Illuminate\Support\Facades\Log;
use App\Jobs\UpdatePhoneNumber;

class TokenController extends Controller
{
    //
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;
    private $client;
    private $config;
    private $banners;

    public function setConfig()
    {
        return $this->config = Products::status()->get();
    }

    public function setBanners()
    {
        return $this->banners = Banner::where('status', 1)->orderBy('id', 'desc')->get();
    }

    public function setLocation($data)
    {
        $user = User::find($data->id);
        if ($user->role === 'basic') {
            if ($user->user_location_android()->first() !== null) {
                $user->share_location_android = $user->user_location_android()->first()->share_location;
                $user->show_on_map_android = $user->user_location_android()->first()->show_on_map;
            } else {
                $user->share_location_android = 0;
                $user->show_on_map_android = 0;
            }
            if ($user->user_location_ios()->first() !== null) {
                $user->share_location_ios = $user->user_location_ios()->first()->share_location;
                $user->show_on_map_ios = $user->user_location_ios()->first()->show_on_map;
            } else {
                $user->share_location_ios = 0;
                $user->show_on_map_ios = 0;
            }
            $response = [
                'android' => [
                    'share_location' => $user->share_location_android,
                    'show_on_map' => $user->show_on_map_android,
                ],
                'ios' => [
                    'share_location' => $user->share_location_ios,
                    'show_on_map' => $user->show_on_map_ios,
                ]
            ];
            return $this->location = $response;
        }
        return $this->location = 'CLOSE';
    }

    public function getBanners()
    {
        return $this->banners;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getTokenLogin()
    {
        $parameters = array(
            'grant_type=client_credentials', 'client_id=eU2Sine8K2zCqO3SQvIqbgECklsoY1JXdXA9l9ST',
            'client_secret=fOmoHWueCMV8CSyrV55AgZJqiiJ7S9b6sMBZ8eNY'
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
        $token = json_decode($token);
        $err = curl_error($curl);

        if ($err) {
            $this->setStatusMessage('There something wrong. Error :' . $err);
            $response = [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        } else {
            $this->setStatusMessage('Success get token login.');
            $response = [
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
                'details' => [
                    'token' => $token,
                ],
            ];
        }
        return $response;
    }

    public function setTokenLogin()
    {
        return Authorizer::issueAccessToken();
    }

    public function getTokenAccess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grant_type' => 'required',
        ]);
        // Log::info($request->all());
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }

        if ($request->version == '3.0.0') {
            $clientId = null;
            $clientSecret = null;
            $client = null;
            $userClientSecret = null;
            $userData = null;
            if ($request->grant_type == 'login') {
                $validator = Validator::make($request->all(), [
                    'username' => 'required',
                    'password' => 'required',
                    'grant_type' => 'required',
                    'device_id' => 'required',
                    'device_type' => 'required',
                ]);
                // change line for delete access_token
                if ($validator->fails()) {
                    $this->setStatusMessage($validator->errors()->first());
                    return [
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ];
                }
                $deviceType = $request->device_type;
                $deviceId = $request->device_id;
                $credentials = [
                    'username' => $request->username,
                    'password' => $request->password,
                ];
                $userLogin = Auth::once($credentials);
                if ($userLogin) {
                    $userData = Auth::user();
                    if ($deviceId == '2438758791809eed' || $deviceId == 'f7fa0859ac7c7985') {
                        $userData->actived = 0;
                        $userData->save();
                        $userData->logs()->save(new \App\UserLog(['log' => 'Freeze because login from ' . $deviceId]));
                        $this->setStatusMessage('Username atau password anda salah');
                        return [
                            'status' => [
                                'code' => $this->getCodeFailed(),
                                'confirm' => $this->getConfirmFailed(),
                                'message' => $this->getStatusMessage(),
                            ],
                        ];
                    }
                    $userData->password_attempt_granted = 3;
                    $userData->save();
                    $userData->logs()->save(new \App\UserLog(['log' => 'Proses login']));
                    if ($userData->actived == 0) {
                        if ($userData->role == 'free') {
                            $userData->logs()->save(new \App\UserLog(['log' => 'Tidak bisa login. ID anda sedang dalam block list atau belum melakukan aktivasi']));
                            $this->setStatusMessage('Maaf Anda tidak bisa login. ID anda sedang dalam block list atau belum melakukan aktivasi. Jika Anda pengguna baru, silahkan lakukan verifikasi email Anda terlebih dahulu. Hubungi cutomer service untuk info lebih lengkap.');
                        } else {
                            $userData->logs()->save(new \App\UserLog(['log' => 'Demi keamanan dan kenyaman, member harap melakukan reset password pada website jaringan.']));
                            $this->setStatusMessage('Demi keamanan dan kenyaman, member harap melakukan reset password pada website jaringan.');
                        }
                        return [
                            'status' => [
                                'code' => $this->getCodeFailed(),
                                'confirm' => $this->getConfirmFailed(),
                                'message' => $this->getStatusMessage(),
                            ],
                        ];
                    }

                    if ($userData->actived == 2) {
                        $userData->logs()->save(new \App\UserLog(['log' => 'Tidak bisa login. Cek email Anda untuk melakukan proses aktivasi.']));
                        $this->setStatusMessage('Silahkan cek email Anda untuk melakukan proses aktivasi.');
                        return [
                            'status' => [
                                'code' => $this->getCodeFailed(),
                                'confirm' => $this->getConfirmFailed(),
                                'message' => $this->getStatusMessage(),
                            ],
                        ];
                    }

                    // START OF DATA CONFIRMATION
                    if ($userData->suspended == 1) {
                        $dataVerifiedBoo = false;
                        if ($request->has('phone_number')) {
                            if ($request->has('otp')) {
                                $validator = Validator::make($request->all(), [
                                    'otp' => 'numeric',
                                ]);
                                if ($validator->fails()) {
                                    $userData->logs()->save(new \App\UserLog(['log' => $validator->errors()->first()]));
                                    $this->setStatusMessage('OTP must be numeric.');
                                    return [
                                        'status' => [
                                            'code' => 402,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => $this->getStatusMessage(),
                                        ],
                                    ];
                                }

                                $dataValidationObj = \App\RequestDataVerification::where('user_id', '=', $userData->id)->where('confirmed', '=', 0)
                                    ->where('status', '=', 1)->orderBy('id', 'desc')->first();
                                if (!$dataValidationObj) {
                                    $userData->logs()->save(new \App\UserLog(['log' => 'Silahkan lakukan konfimasi nomer handpohone Anda. Kami akan mengirimkan SMS konfirmasi.']));
                                    return [
                                        'status' => [
                                            'code' => 401,
                                            'confirm' => 'confirmation',
                                            'message' => ['Smart in pays will use this phone number as login account for this app'],
                                        ],
                                    ];
                                }
                                $dataValidationObj->hit -= 1;
                                $dataValidationObj->save();
                                if ($dataValidationObj->otp != $request->otp) {
                                    \App\UserLog::create([
                                        'user_id' => $userData->id,
                                        'log' => 'Failed OTP. OTP request : ' . $request->otp . '. Hit :' . $dataValidationObj->hit
                                    ]);
                                    if ($dataValidationObj->hit == 0) {
                                        $dataValidationObj->status = 3;
                                        $dataValidationObj->save();
                                        $userData->actived = 0;
                                        $userData->save();
                                        \App\UserLog::create([
                                            'user_id' => $userData->id,
                                            'log' => 'ID banned !'
                                        ]);
                                        return [
                                            'status' => [
                                                'code' => 400,
                                                'confirm' => $this->getConfirmFailed(),
                                                'message' => [' Your ID is blocked. Because you are wrong 30 times. Please call customer service.'],
                                            ],
                                        ];
                                    }
                                    return [
                                        'status' => [
                                            'code' => 403,
                                            'confirm' => 'confirmation',
                                            'message' => ['OTP is wrong, please try again.'],
                                        ],
                                        'data' => [
                                            'hit' => $dataValidationObj->hit,
                                            'expired' => $dataValidationObj->expired
                                        ]
                                    ];
                                }

                                $expiredInt = strtotime($dataValidationObj->created_at);
                                $nowInt = time();
                                $calculationTimeInt = $nowInt - $expiredInt;
                                if ($calculationTimeInt > 420) {
                                    \App\UserLog::create([
                                        'user_id' => $userData->id,
                                        'Log' => 'Failed OTP. OTP request : ' . $request->otp . 'Note : OTP is expired'
                                    ]);
                                    return [
                                        'status' => [
                                            'code' => 401,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => ['OTP has been expired. Please click \'RESEND CODE\' .'],
                                        ],
                                    ];
                                }
                                DB::beginTransaction();
                                try {
                                    $userData->email = $dataValidationObj->email;
                                    $userData->phone_number = $dataValidationObj->phone;
                                    $userData->suspended = 0;
                                    $userData->save();
                                    $dataValidationObj->confirmed = 1;
                                    $dataValidationObj->status = 1;
                                    $dataValidationObj->save();
                                    \App\UserLog::create([
                                        'user_id' => $userData->id,
                                        'log' => 'Success verification. OTP request : ' . $request->otp
                                    ]);
                                } catch (\Exception $eObj) {
                                    DB::rollback();
                                    return [
                                        'status' => [
                                            'code' => 403,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => ['Something went wrong. Please try again'],
                                        ],
                                        'data' => [
                                            'hit' => $dataValidationObj->hit,
                                            'expired' => $dataValidationObj->expired
                                        ]
                                    ];
                                }
                                DB::commit();
                                $dataVerifiedBoo = true;
                            }
                            if (!$dataVerifiedBoo) {
                                $checkDataObj = \App\RequestDataVerification::where('user_id', '=', $userData->id)
                                    ->where('phone', '=', $request->phone_number)->where('email', '=', $userData->email)
                                    ->where('confirmed', '=', 0)->where('status', '=', 1)->orderBy('id', 'desc')->first();
                                if ($checkDataObj) {
                                    $expiredInt = strtotime($checkDataObj->created_at);
                                    $nowInt = time();
                                    $calculationTimeInt = $nowInt - $expiredInt;
                                    if ($calculationTimeInt < 420) {
                                        $phoneLen = strlen($checkDataObj->phone);
                                        $phonePre = substr($checkDataObj->phone, 0, 4);
                                        $phonePost = substr($checkDataObj->phone, -3);
                                        $phoneMid = '';
                                        for ($i = 0; $i <= ($phoneLen - 7); $i++) {
                                            $phoneMid .= 'X';
                                        }
                                        return [
                                            'status' => [
                                                'code' => 403,
                                                'confirm' => 'confirmation',
                                                'message' => ['We sent you an OTP code to ' . $phonePre . $phoneMid . $phonePost],
                                            ],
                                            'data' => [
                                                'hit' => $checkDataObj->hit,
                                                'expired' => $checkDataObj->expired
                                            ]
                                        ];
                                    }
                                    $checkDataObj->status = 3;
                                    $checkDataObj->save();
                                }
                                // $validator = Validator::make($request->all(), [
                                //     'email' => 'email',
                                // ]);
                                // if ($validator->fails()) {
                                //     $this->setStatusMessage($validator->errors()->first());
                                //     return [
                                //         'status' => [
                                //             'code' => 402,
                                //             'confirm' => $this->getConfirmFailed(),
                                //             'message' => $this->getStatusMessage(),
                                //         ],
                                //     ];
                                // }

                                // $emailAvailableBoo = true;
                                // /**
                                //  * START
                                //  * Check email available
                                //  */
                                // $emailObjArr = User::where('email', '=', $request->email)->get();
                                // if ($emailObjArr->count() > 0) {
                                //     foreach ($emailObjArr as $emailObj) {
                                //         if ($emailObj->suspended == 0) {
                                //             $emailAvailableBoo = false;
                                //             break;
                                //         }
                                //     }
                                //     if (!$emailAvailableBoo) {
                                //         return [
                                //             'status' => [
                                //                 'code' => 402,
                                //                 'confirm' => $this->getConfirmFailed(),
                                //                 'message' => ['Email sudah digunakan.'],
                                //             ],
                                //         ];
                                //     }
                                // }
                                // END of check email available


                                $validator = Validator::make($request->all(), [
                                    'phone_number' => 'numeric',
                                ]);
                                if ($validator->fails()) {
                                    $this->setStatusMessage('Phone number must be numeric.');
                                    return [
                                        'status' => [
                                            'code' => 402,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => $this->getStatusMessage(),
                                        ],
                                    ];
                                }
                                if (substr($request->phone_number, 0, 2) != '08') {
                                    $this->setStatusMessage('Phone number is invalid. Make sure your phone number starts at 08xxxxxx');
                                    return [
                                        'status' => [
                                            'code' => 402,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => $this->getStatusMessage(),
                                        ],
                                    ];
                                }

                                if (strlen($request->phone_number) > 13) {
                                    $this->setStatusMessage('Phone number is invalid. Phone number is to long.');
                                    return [
                                        'status' => [
                                            'code' => 402,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => $this->getStatusMessage(),
                                        ],
                                    ];
                                }
                                /**
                                 * Check phone number available
                                 */
                                $phoneNumberObjArr = User::where('phone_number', '=', $request->phone_number)->get();
                                if ($phoneNumberObjArr->count() > 0) {
                                    return [
                                        'status' => [
                                            'code' => 402,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => ['Phone number has been used.'],
                                        ],
                                    ];
                                }
                                // END of check phone number

                                DB::beginTransaction();
                                try {
                                    $checkDataObjArr = \App\RequestDataVerification::where('user_id', '=', $userData->id)
                                        ->where('confirmed', '=', 0)->where('status', '=', 1)->get();
                                    foreach ($checkDataObjArr as $checkDataObj) {
                                        $checkDataObj->status = 3;
                                        $checkDataObj->save();
                                    }
                                    $otp = $this->getOtpId($userData->id);
                                    $requestData = new \App\RequestDataVerification;
                                    $requestData->user_id = $userData->id;
                                    $requestData->email = $userData->email;
                                    $requestData->phone = $request->phone_number;
                                    $requestData->otp = $otp;
                                    $requestData->hit = 30;
                                    $requestData->expired = date("Y-m-d H:i:s", time() + 420);
                                    $requestData->save();

                                    $param = [
                                        'rqid' => 'Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT',
                                        'mmid' => 'mastersip',
                                        'app' => 'transaction',
                                        'action' => 'send_sms',
                                        'nohp' => trim($requestData->phone),
                                        'pesan' => 'OTP verifikasi ' . $requestData->otp . '. Berlaku sampai ' . date('Y-m-d H:i', strtotime($requestData->expired)) . ' WIB.   Pastikan Anda TIDAK MEMBERIKAN kode OTP kepada siapapun (termasuk pihak Smart In Pays).'
                                    ];
                                    $param = json_encode($param);
                                    $sms = SipSms::send($param)->get();
                                    if ($sms['error_code'] == '000') {
                                        $requestData->status = 1;
                                        $requestData->save();
                                    } else {
                                        $requestData->status = 4;
                                        $requestData->save();
                                    }
                                } catch (\Exception $eObj) {
                                    DB::rollback();
                                    return [
                                        'status' => [
                                            'code' => 402,
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => ['Something went wrong, please try again'],
                                        ],
                                    ];
                                }
                                DB::commit();
                                $phoneLen = strlen($request->phone_number);
                                $phonePre = substr($request->phone_number, 0, 4);
                                $phonePost = substr($request->phone_number, -3);
                                $phoneMid = '';
                                for ($i = 0; $i <= ($phoneLen - 7); $i++) {
                                    $phoneMid .= 'X';
                                }
                                return [
                                    'status' => [
                                        'code' => 403,
                                        'confirm' => 'confirmation',
                                        'message' => ['We sent you an OTP code to ' . $phonePre . $phoneMid . $phonePost],
                                    ],
                                    'data' => [
                                        'hit' => $requestData->hit,
                                        'expired' => $requestData->expired
                                    ]
                                ];
                            }
                        }
                        if (!$dataVerifiedBoo) {
//                            $this->setStatusMessage('Smart in pays will use this phone number as login account for this app.');
//                            return [
//                                'status' => [
//                                    'code' => 401,
//                                    'confirm' => 'confirmation',
//                                    'message' => $this->getStatusMessage(),
//                                ],
//                            ];
                            $this->setStatusMessage('Demi kemudahan dan kenyamanan anda, kami sedang melakukan update aplikasi smart in pays. Jika anda tidak dapat melakukan proses verifikasi silahkan mengupdate versi terbaru aplikasi smart in pays anda ke versi 3.0.0. Jika masih mengalami kendala silahkan menghubungi customer service kami di 1500-107');
                            return [
                                'status' => [
                                    'code' => 400,
                                    'confirm' => 'failed',
                                    'message' => $this->getStatusMessage(),
                                ],
                            ];
                        }
                        $this->dispatch(new UpdatePhoneNumber($userData->username, $request->phone_number));
                    }
                    // END OF DATA CONFIRMATION

                    if ($request->has('access_token')) {
                        $accessToken = OauthAccessToken::find($request->access_token);
                        $accessToken->delete();
                    }
                    if ($request->hasHeader('authorization')) {
                        $token = explode(' ', $request->header('authorization'));
                        $accessToken = OauthAccessToken::find($token[1]);
                        $accessToken->delete();
                    }
                    $userClientSecret = $userData->client_secrets()->where('device_type', strtolower($deviceType))
                        ->get()->first();
                    if (!$userClientSecret) {
                        if ($userData->role == 'free') {
                            $devices = OauthClientSecret::where('device_id', $deviceId)->get();
                            foreach ($devices as $device) {
                                if ($device->user->role == 'free') {
                                    $this->setStatusMessage('Device Anda sudah terdaftar dengan user free yang lain.');
                                    return [
                                        'status' => [
                                            'code' => $this->getCodeFailed(),
                                            'confirm' => $this->getConfirmFailed(),
                                            'message' => $this->getStatusMessage(),
                                        ],
                                    ];
                                }
                            }
                        }
                        $clientId = $this->getClientId();
                        $clientSecret = $this->getClientSecret();
                        DB::beginTransaction();
                        try {
                            $userData->client_secrets()->save(new OauthClientSecret([
                                'client_id' => $clientId,
                                'client_secret' => $clientSecret,
                                'device_type' => $deviceType,
                                'device_id' => $deviceId,
                            ]));
                            $newOauthClient = new OauthClient();
                            $newOauthClient->id = $clientId;
                            $newOauthClient->secret = $clientSecret;
                            $newOauthClient->name = $deviceType;
                            $newOauthClient->save();
                        } catch (Exception $e) {
                            DB::rollback();
                            $this->setStatusMessage('Error : ' . $e);
                            return [
                                'status' => [
                                    'code' => $this->getCodeFailed(),
                                    'confirm' => $this->getConfirmFailed(),
                                    'message' => $this->getStatusMessage(),
                                ],
                            ];
                        }
                        DB::commit();
                        $this->client = [
                            'client_id' => $clientId,
                            'client_secret' => $clientSecret,
                        ];
                    } elseif ($userClientSecret->device_id != $deviceId && $userClientSecret->user_id != 1327) {
                        $userData->logs()->save(new \App\UserLog(['log' => 'Perangkat Anda tidak terdaftar.']));
                        $this->setStatusMessage('Perangkat Anda tidak terdaftar.');
                        return [
                            'status' => [
                                'code' => $this->getCodeFailed(),
                                'confirm' => $this->getConfirmFailed(),
                                'message' => $this->getStatusMessage(),
                            ],
                        ];
                    } else {
                        if ($userClientSecret->user_id != 1327) {
                            if ($userClientSecret->device_id != $deviceId) {
                                $userData->logs()->save(new \App\UserLog(['log' => 'Perangkat Anda tidak terdaftar.']));
                                $this->setStatusMessage('Perangkat Anda tidak terdaftar.');
                                return [
                                    'status' => [
                                        'code' => $this->getCodeFailed(),
                                        'confirm' => $this->getConfirmFailed(),
                                        'message' => $this->getStatusMessage(),
                                    ],
                                ];
                            }
                        }
                        $this->client = [
                            'client_id' => $userClientSecret->client_id,
                            'client_secret' => $userClientSecret->client_secret,
                        ];
                    }
                    $parameters = array(
                        'grant_type=login', 'client_id=' . $this->client['client_id'] . '',
                        'client_secret=' . $this->client['client_secret'] . '', 'username=' . $request->username . '', 'password=' . $request->password . ''
                    );
                    $parameters = implode('&', $parameters);
                    // Log::info($parameters);
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
                    if (isset($token['error'])) {
                        $userData->logs()->save(new \App\UserLog(['log' => 'Login gagal. Error : ' . $token['error_description']]));
                        $message = array('Login gagal.', $token['error_description']);
                        $this->setStatusMessage($message);
                        return [
                            'status' => [
                                'code' => $this->getCodeFailed(),
                                'confirm' => $this->getConfirmFailed(),
                                'message' => $this->getStatusMessage(),
                            ],
                        ];
                    }
                    $token['client_id'] = $this->client['client_id'];
                    $token['client_secret'] = $this->client['client_secret'];
                    $this->setLocation($userData);
                    $this->setConfig();
                    $this->setBanners();
                    $this->setStatusMessage('Login berhasil.');

                    if ($request->has('lat') && $request->has('lng') && (int)$request->lat != '0' && $request->lng != '0') {
                        $userLoc = UserLocation::where('user_id', '=', $userData->id)
                            ->where('device', '=', $userClientSecret->device_type)->first();
                        if (!$userLoc) {
                            Log::info('Masuk sini');
                            $userLoc = UserLocation::create([
                                'user_id' => $userData->id,
                                'type_user_id' => $userData->type_user_id,
                                'device' => $userClientSecret->device_type,
                                'lat' => $request->lat,
                                'lng' => $request->lng,
                            ]);
                            if ($userLoc) {
                                Log::info('created');
                            }
                        } else {
                            $userLoc = UserLocation::where('user_id', '=', $userData->id)
                                ->where('device', '=', $userClientSecret->device_type)
                                ->update([
                                    'type_user_id' => $userData->type_user_id,
                                    'lat' => $request->lat,
                                    'lng' => $request->lng,
                                ]);
                        }
                    }
                    $response = [
                        'status' => [
                            'code' => 200,
                            'confirm' => 'success',
                            'message' => $this->getStatusMessage(),
                        ],
                        'details' => [
                            'token' => $token,
                            'user' => $userData,
                            'referral' => $userData->username,
                            'upline' => [
                                'nama' => $userData->parent->name,
                                'email' => $userData->parent->email,
                                'phone' => $userData->parent->address->phone,
                            ],
                            'config' => $this->getConfig(),
                            'banners' => $this->getBanners(),
                            'url_android' => 'https://play.google.com/store/apps/details?id=com.droid.sip',
                            'url_ios' => 'https://appsto.re/id/m9pjkb.i',
                        ],
                    ];
                    $response['details']['config']['LOCATIONS'] = $this->getLocation();
                    $campaign = \App\SipCampaign::where('status', '=', '1')->orderBy('created_at', 'asc')->first();
                    if ($campaign) {
                        $hasSaw = $userData->content_viewers()->where('content_type', '=', 'campaign')->where('content_id', '=', $campaign->id)->first();
                        if (!$hasSaw) {
                            $response['details']['campaign'] = null;
                            if ($userData->username == 'member_platinum') {
                                $response['details']['campaign'] = [
                                    'id' => $campaign->id,
                                    'url_video' => $campaign->url_content,
                                    'url_youtube' => $campaign->url_youtube
                                ];
                            }
                        } else {
                            $response['details']['campaign'] = null;
                        }
                    }
                    $userData->logs()->save(new \App\UserLog(['log' => 'Login berhasil']));
                    return $response;
                } else {
                    $this->setStatusMessage('Username atau password anda salah');
                    $user = User::where('username', '=', $request->username)->first();
                    if ($user) {
                        if ($user->actived) {
                            $user->password_attempt_granted = $user->password_attempt_granted - 1;
                            $user->save();
                            $this->setStatusMessage('Username atau password anda salah. Anda memiliki ' . $user->password_attempt_granted . ' kali kesempatan lagi.');
                            if ($user->password_attempt_granted == 0) {
                                $user->actived = 0;
                                $user->save();
                                $user->logs()->save(new \App\UserLog(['log' => 'Lock by login attempt']));
                                if ($user->role == 'free') {
                                    $this->setStatusMessage('ID Anda telah terblokir, silahkan melakukan reset password.');
                                } else {
                                    $this->setStatusMessage('ID Anda telah terblokir, silahkan melakukan reset password pada website jaringan www.sipindonesia.com');
                                }
                            }
                        } else {
                            if ($user->role == 'free') {
                                $this->setStatusMessage('ID Anda telah terblokir, silahkan melakukan reset password.');
                            } else {
                                $this->setStatusMessage('ID Anda telah terblokir, silahkan melakukan reset password pada website jaringan www.sipindonesia.com');
                            }
                        }
                    }
                    return [
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ];
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'client_id' => 'required',
                    'client_secret' => 'required',
                    'grant_type' => 'required',
                    'refresh_token' => 'required',
                ]);
                if ($validator->fails()) {
                    $this->setStatusMessage($validator->errors());
                    return [
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ];
                }
                $clientId = $request->client_id;
                $clientSecret = $request->client_secret;
                $this->client = [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                ];
                $userClientSecret = OauthClientSecret::where('client_id', $this->client['client_id'])->first();
                if (!$userClientSecret) {
                    $message = array(
                        'Perangkat Anda telah di reset. Silahkan login kembali.', 'check your params', 'If you do refresh token, params needed is client_id, client_secret, refresh_token, and grant_type with value \'refresh_token\'',
                        'If you do login, params needed is device_id, device_type, username, password, and grant_type with value \'login\''
                    );
                    $this->setStatusMessage($message);
                    return [
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ];
                }
                $userData = $userClientSecret->user;
                if ($userData->suspended == 1) {
                    $message = array('Demi keamanan dan kenyaman, member harap melakukan reset password pada website jaringan.');
                    $this->setStatusMessage($message);
                    return [
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ];
                }
                if ($request->has('lat') && $request->has('lng') && $request->lat != '0' && $request->lng != '0') {
                    $userLoc = UserLocation::where('user_id', '=', $userData->id)
                        ->where('device', '=', $userClientSecret->device_type)->first();
                    if (!$userLoc) {
                        $userLoc = UserLocation::create([
                            'user_id' => $userData->id,
                            'type_user_id' => $userData->type_user_id,
                            'device' => $userClientSecret->device_type,
                            'lat' => $request->lat,
                            'lng' => $request->lng,
                        ]);
                    } else {
                        $userLoc = UserLocation::where('user_id', '=', $userData->id)
                            ->where('device', '=', $userClientSecret->device_type)
                            ->update([
                                'type_user_id' => $userData->type_user_id,
                                'lat' => $request->lat,
                                'lng' => $request->lng,
                            ]);
                    }
                }
                $parameters = array(
                    'grant_type=refresh_token', 'client_id=' . $this->client['client_id'] . '',
                    'client_secret=' . $this->client['client_secret'] . '', 'refresh_token=' . $request->refresh_token . ''
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
                curl_close($curl);
                $token = json_decode($token, true);
                if (isset($token['error'])) {
                    $message = array('Refresh token gagal', $token['error_description']);
                    $this->setStatusMessage($message);
                    return [
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ];
                }
                $token['client_id'] = $this->client['client_id'];
                $token['client_secret'] = $this->client['client_secret'];
                $this->setLocation($userData);
                $this->setConfig();
                $this->setBanners();
                $this->setStatusMessage('Refresh token berhasil');
                $response = [
                    'status' => [
                        'code' => $this->getCodeSuccess(),
                        'confirm' => $this->getConfirmSuccess(),
                        'message' => $this->getStatusMessage(),
                    ],
                    'details' => [
                        'token' => $token,
                        'user' => $userData,
                        'referral' => $userData->username,
                        'upline' => [
                            'nama' => $userData->parent->name,
                            'email' => $userData->parent->email,
                            'phone' => $userData->parent->address->phone,
                        ],
                        'config' => $this->getConfig(),
                        'banners' => $this->getBanners(),
                        'url_android' => 'https://play.google.com/store/apps/details?id=com.droid.sip',
                        'url_ios' => 'https://appsto.re/id/m9pjkb.i',
                    ],
                ];
                $response['details']['config']['LOCATIONS'] = $this->getLocation();
                $campaign = \App\SipCampaign::where('status', '=', '1')->orderBy('created_at', 'asc')->first();
                if ($campaign) {
                    $hasSaw = $userData->content_viewers()->where('content_type', '=', 'campaign')->where('content_id', '=', $campaign->id)->first();
                    if (!$hasSaw) {
                        $response['details']['campaign'] = null;
                        if ($userData->username == 'member_platinum') {
                            $response['details']['campaign'] = [
                                'id' => $campaign->id,
                                'url_video' => $campaign->url_content,
                                'url_youtube' => $campaign->url_youtube
                            ];
                        }
                    } else {
                        $response['details']['campaign'] = null;
                    }
                }
                return $response;
            }
        }
        $this->setStatusMessage('Versi aplikasi Anda sudah kadaluarsa. Silahkan update aplikasi SIP Anda.');
        return [
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ];
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

    private function getOtpId($userId)
    {
        $i = 1;
        $otpId = null;
        $date = date('Y-m-d', time());
        while (true) {
            $otpId = $i . substr("" . time(), -5);
            if (\App\RequestDataVerification::where('user_id', $userId)->where('otp', '=', $otpId)->first() === null) {
                break;
            }
            $i++;
        }
        return $otpId;
    }
}
