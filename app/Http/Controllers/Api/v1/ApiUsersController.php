<?php

namespace App\Http\Controllers\Api\v1;

use App\Address;
use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClient;
use App\OauthClientSecret;
use App\TravelAgent;
use App\User;
use App\UserPhoto;
use App\UserReferral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Mail;

class ApiUsersController extends Controller
{
    //
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;
    public function __construct(Request $request)
    {
        $this->middleware('oauth');
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
    public function store(Request $request)
    {
        if (trim($request->referral) == '') {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => ['Referral wajib di isi.'],
                ],
            ], 400);
        }
        if ($request->has('access_token')) {
            $accessToken = OauthAccessToken::find($request->access_token);
            $accessToken->delete();
        }
        if ($request->hasHeader('authorization')) {
            $token = explode(' ', $request->header('authorization'));
            $accessToken = OauthAccessToken::find($token[1]);
            $accessToken->delete();
        }
        $validator = Validator::make($request->all(), [
            'member_phone' => 'required',
            'username' => 'required|alpha_num|min:6|max:25|unique:users,username',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
//            'password' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'referral' => 'required|exists:users,username',
            'device_id' => 'required',
            'device_type' => 'required',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors()->first(),
                ],
            ], 400);
        }
        $devices = OauthClientSecret::where('device_id', $request->device_id)->where('device_type', $request->device_type)->get();
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
        $user = User::where('username', trim($request->referral))->first();
        if (!$user) {
            $this->setStatusMessage('Maaf kode referral tidak ditemukan.');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        $downline = $user->childs;
        $countDownline = count($downline);
        if ($user->role != 'free') {
            $upline = $user->id;
            if ($user->role == 'basic' && $countDownline > 9) {
                $this->setStatusMessage('Maaf kode referral yang Anda gunakan sudah mencapai limit.');
                return [
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ];
            } elseif ($user->role == 'advance' && $countDownline > 29) {
                $this->setStatusMessage('Maaf kode referral yang Anda gunakan sudah mencapai limit.');
                return [
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ];
            }
        } else {
            $this->setStatusMessage('Maaf kode referral tidak ditemukan.');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        $clientId = $this->getClientId();
        $clientSecret = $this->getClientSecret();
        $ref = null;
        DB::beginTransaction();
        try {
            $member_address = Address::create([
                'detail' => '',
                'subdistrict_id' => 999999,
                'phone' => $request->member_phone,
            ]);
            $travel_address = Address::create([
                'detail' => '',
                'subdistrict_id' => 999999,
                'phone' => $request->member_phone,
            ]);

            $member_address->user()->save($newUser = new User([
                'username' => trim($request->username),
                'name' => $request->name,
                'email' => $request->email,
//                'password' => bcrypt($request->password),
                'role' => 'free',
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'upline' => $upline,
                'created_by' => $user->id,
                'actived' => 2,
                'type_user_id' => 5,
            ]));

            $newUser->travel_agent()->save(new TravelAgent([
                'name' => 'Isi nama travel Anda disini',
                'address_id' => $travel_address->id,
            ]));
            $newUser->referral()->save($ref = new UserReferral([
                'referral' => $this->getReferral(),
            ]));

            $newUser->client_secrets()->save(new OauthClientSecret([
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'device_type' => strtolower($request->device_type),
                'device_id' => $request->device_id,
            ]));
            $newOauthClient = new OauthClient();
            $newOauthClient->id = $clientId;
            $newOauthClient->secret = $clientSecret;
            $newOauthClient->name = strtolower($request->device_type);
            $newOauthClient->save();
        } catch (\Exception $e) {
            DB::rollback();
        }
        DB::commit();
        Mail::send('emails.notif-registration-free-users', ['user' => $newUser, 'password' => $request->password, 'referral' => $ref], function ($m) use ($newUser) {
            $m->from('no_reply@smartinpays.com', 'Smart In Pays');
            $m->to($newUser->email, $newUser->name)->subject('Welcome to Smart In Pays');
        });
        Mail::send('emails.notif-registration-upline', ['user' => $newUser], function ($m) use ($newUser) {
            $m->from('no_reply@smartinpays.com', 'Smart In Pays');
            $m->to($newUser->parent->email, $newUser->parent->name)->subject('Welcome to Smart In Pays');
        });
        $this->setStatusMessage('Registrasi berhasil, silahkan periksa email Anda untuk melakukan verifikasi. Terimakasih.');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'data' => $request->all()
            ],
        ]);
    }
    public function resetPassword(Request $request)
    {
        if ($request->has('access_token')) {
            $accessToken = OauthAccessToken::find($request->access_token);
            $accessToken->delete();
        }
        if ($request->hasHeader('authorization')) {
            $token = explode(' ', $request->header('authorization'));
            $accessToken = OauthAccessToken::find($token[1]);
            $accessToken->delete();
        }
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'email' => 'required|exists:users,email',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors()->first(),
                ],
            ], 400);
        }
        $user = User::where('username', $request->username)->first();
        if ($user->role != 'free') {
            $this->setStatusMessage('Mohon maaf Anda tidak dapat melakukan reset password, untuk melakukan reset password silahkan menghubungi ke cs@mysmartinpays.net');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        if ($user->actived == 0) {
            $this->setStatusMessage('Maaf Anda tidak bisa reset password. ID anda sedang dalam block list atau belum melakukan aktivasi. Jika Anda pengguna baru, silahkan lakukan verifikasi email Anda terlebih dahulu. Hubungi cutomer service untuk info lebih lengkap.');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        if ($user->email == $request->email) {
            DB::beginTransaction();
            try {
                $newPassword = strtoupper(str_random(8));
                $user->password = bcrypt($newPassword);
                $user->save();
                Mail::send('emails.reset-password', ['user' => $user, 'newPassword' => $newPassword], function ($m) use ($user) {
                    $m->from('no_reply@smartinpays.com', 'Smart In Pays');
                    $m->to($user->email, $user->name)->subject('Reset Password Smart In Pays');
                });
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
            $this->setStatusMessage('Reset password berhasil. Silahkan cek email Anda.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $this->setStatusMessage('Username dan email tidak sesuai.');
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors(),
                ],
            ]);
        }
        $client = OauthClientSecret::where('client_id', $request->client_id)->first();
        if (!$client) {
            $this->setStatusMessage(['Anda tidak terdaftar', 'client_id tidak ditemukan']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $user = $client->user;
        if ($user->actived == 0) {
            $this->setStatusMessage('Maaf, ID anda sedang dalam block list. Silahkan hubungi cutomer service.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        if (Auth::once(['email' => $user->email, 'password' => $request->old_password])) {
            $user->password = bcrypt($request->new_password);
            $user->save();
            $this->setStatusMessage('Ganti password berhasil.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $this->setStatusMessage('Old password wrong.');
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
    }
    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'photo' => 'required|file|image|mimes:jpeg,jpg,bmp,png|max:50',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors(),
                ],
            ]);
        }
        $client = OauthClientSecret::where('client_id', $request->client_id)->first();
        if (!$client) {
            $this->setStatusMessage(['Anda tidak terdaftar', 'client_id tidak ditemukan']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $user = $client->user;
        $userphoto = UserPhoto::where('user_id', '=', $user->id)->first();
        $photo = $request->file('photo');
        $originalName = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
        $fileName = $this->sanitize($originalNameWithoutExt);
        $allowedFileName = $this->createUniqueFilenamePhoto($fileName, $extension);
        $uploadSuccess = $this->uploadFoto($photo, $allowedFileName);
        if (!$uploadSuccess) {
            $this->setStatusMessage('Gagal mengganti foto profil. Periksa kembali file yang Anda upload.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        if ($userphoto == null) {
            $newuserphoto = new UserPhoto;
            $newuserphoto->user_id = $user->id;
            $newuserphoto->url_photo = $this->generateURLPhoto($allowedFileName);
            $newuserphoto->file_name = $allowedFileName;
            $newuserphoto->save();
        } else {
            $this->deletePhoto($userphoto->file_name);
            $userphoto->url_photo = $this->generateURLPhoto($allowedFileName);
            $userphoto->file_name = $allowedFileName;
            $userphoto->save();
        }
        $this->setStatusMessage('Berhasil Memperbaharui foto profil');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
    }
    public function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array(
            "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?"
        );
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ? (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
    }
    public function createUniqueFilenamePhoto($filename, $extension)
    {
        $photo_dir = Config::get('sip-config.user_dir');
        $photo_path = $photo_dir . $filename . '.' . $extension;
        if (File::exists($photo_path)) {
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }
        return $filename . '.' . $extension;
    }
    public function uploadFoto($photo, $fileName)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->resize(200, 200)->save(Config::get('sip-config.user_dir') . $fileName);
        return $image;
    }
    public function generateURLPhoto($filename)
    {
        $url = URL::to('/') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'user'
            . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $filename;
        return $url;
    }
    public function deletePhoto($fileName)
    {
        $photo = Config::get('sip-config.user_dir');
        $full_path = $photo . $fileName;
        if (File::exists($full_path)) {
            File::delete($full_path);
        }
        return true;
    }
    public function seeContent(Request $request)
    {
        //        return $request->all();
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'content_type' => 'required',
            'content_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors(),
                ],
            ]);
        }
        $client = OauthClientSecret::where('client_id', $request->client_id)->first();
        if (!$client) {
            $this->setStatusMessage(['Anda tidak terdaftar', 'client_id tidak ditemukan']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $user = $client->user;
        if ($request->content_type == 'campaign') {
            \App\UserContentViewer::firstOrCreate([
                'user_id' => $user->id,
                'content_type' => $request->content_type,
                'content_id' => $request->content_id
            ]);
            $this->setStatusMessage(['Success record!']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $this->setStatusMessage(['Content type does\'nt exists']);
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
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
    public function getReferral()
    {
        $ref = null;
        while (true) {
            $ref = strtoupper(str_random(6));
            if (UserReferral::where('referral', $ref)->first() === null) {
                break;
            }
        }
        return $ref;
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
