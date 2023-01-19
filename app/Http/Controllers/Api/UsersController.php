<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Deposit\Deposit;
use App\Helpers\SipSms;
use DB;
use Log;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('username')) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|exists:users,username'
            ]);
            if ($validator->fails()) {
                return [
                    'status' => [
                        'code' => 400,
                        'confirm' => 'failed',
                        'message' => $validator->errors()
                    ]
                ];
            }
            $user = User::where('username', $request->username)->first();
            $users = $user->childs;
            return [
                'status' => [
                    'code' => 200,
                    'confirm' => 'success',
                    'message' => 'Success get users free'
                ],
                'details' => $users
            ];
        } else {
            if ($request->has('date')) {
                $validator = Validator::make($request->all(), [
                    'date' => 'date'
                ]);
                if ($validator->fails()) {
                    return [
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => $validator->errors()
                        ]
                    ];
                }
                $users = User::where('role', 'free')->where('created_at', 'LIKE', $request->date . '%')->get();
                return [
                    'status' => [
                        'code' => 200,
                        'confirm' => 'success',
                        'message' => 'Success get users free'
                    ],
                    'details' => $users
                ];
            }
        }
        return [
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => 'Failed get users free. Please input username upline or date registration.'
            ]
        ];
    }

    public function find(Request $request)
    {
        if ($request->has('phone')) {
            $user = User::where('username', $request->username)->first();
            $phoneNumber = User::where('phone_number', '=', $request->phone)->first();
        } else {
            $user = User::where('username', $request->username)->first();
        }
        $response = [
            'status' => [
                'code' => 200,
                'confirm' => 'success',
                'message' => 'Success check username'
            ],
        ];
        if ($user) {
            $response['details']['username_available'] = false;
            $response['details']['username_email'] = $user->email;
            $response['details']['name'] = $user->name;
            $response['details']['email'] = $user->email;

        } else {
            $response['details']['username_available'] = true;
        }
        if ($request->has('phone')) {
            if ($phoneNumber) {
                $response['details']['phone_available'] = false;
                $response['details']['phone_email'] = $phoneNumber->email;
                $response['details']['type'] = $phoneNumber->role;
            } else {
                $response['details']['phone_available'] = true;
            }
        }
        return $response;
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username'
        ]);
        if ($validator->fails()) {
            return [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors()->first()
                ]
            ];
        }
        // if($request->has('email')){
        //   $validator=Validator::make($request->all(),[
        //     'email'=>'required|email|unique:users,email'
        //   ]);
        //   if($validator->fails()){
        //       return [
        //           'status'=>[
        //               'code'=>400,
        //               'confirm'=>'failed',
        //               'message'=>$validator->errors()->first()
        //           ]
        //       ];
        //   }
        // }
        // if($request->has('phone')){
        //   $validator=Validator::make($request->all(),[
        //     'phone'=>'required|numeric|unique:addresses'
        //   ]);
        //   if($validator->fails()){
        //       return [
        //           'status'=>[
        //               'code'=>400,
        //               'confirm'=>'failed',
        //               'message'=>$validator->errors()->first()
        //           ]
        //       ];
        //   }
        // }
        $user = User::where('username', $request->username)->first();
        DB::beginTransaction();
        try {
            if ($request->has('email')) {
                $user->email = strtolower($request->email);
                $user->save();
            }
            if ($request->has('phone')) {
                $user->address->phone = $request->phone;
                $user->address->save();
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('Failed update data member . Error : ' . $e->getMessage());
            return [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => 'Failed update data member'
                ]
            ];
        }
        DB::commit();
        return [
            'status' => [
                'code' => 200,
                'confirm' => 'success',
                'message' => 'Success update data member'
            ]
        ];
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'new_password' => 'required',
            'activation' => 'required'
        ]);
        if ($validator->fails()) {
            return [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors()->first()
                ]
            ];
        }
        $user = User::where('username', $request->username)->first();

        $requestList = \App\RequestResetPassword::where('user_id', $user->id)
            ->where('status', 0)->get();
        if ($requestList) {
            foreach ($requestList as $key => $value) {
                $value->status = 3;
                $value->save();
            }
        }
        if ($user) {
            $limit = null;
            if ((int)$request->activation === 1) {
                $admin = 0;
                // $user->password=bcrypt($request->new_password);
                // $user->actived=1;
                $id = $this->getTransactionId();
                $limit = date("Y-m-d H:i:s", time() + 300);
                $requestReset = $user->request_reset_passwords()->create([
                    'otp' => $id,
                    'new_password' => bcrypt($request->new_password),
                    'admin' => $admin,
                    'activation' => 1,
                    'expired' => $limit,
                    'status' => 1
                ]);
                $user->password_attempt_granted = 3;
                $user->actived = 1;
                $user->pin_attempt_granted = 5;
                $user->pin = NULL;
//                $user->suspended = 0;
                $user->save();
            } else {
                $admin = 0;
                $id = $this->getTransactionId();
                $limit = date("Y-m-d H:i:s", time() + 300);
                $requestReset = $user->request_reset_passwords()->create([
                    'otp' => $id,
                    'new_password' => bcrypt($request->new_password),
                    'admin' => $admin,
                    'expired' => $limit,
                    'status' => 1
                ]);
            }
            $user->password = bcrypt($request->new_password);
            $user->password_attempt_granted = 3;
            $user->actived = 1;
            $user->pin_attempt_granted = 5;
            $user->pin = NULL;
//            $user->suspended = 0;
            $user->save();

            return [
                'status' => [
                    'code' => 200,
                    'confirm' => 'success',
                    'message' => date('d-M-y H:i:s', strtotime($limit)) . ' WIB.'
                ]
            ];
        }
        return [
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => 'Username not found !'
            ]
        ];
    }

    public function setPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'new_password' => 'required',
            'activation' => 'required'
        ]);
        if ($validator->fails()) {
            return [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors()->first()
                ]
            ];
        }
        $user = User::where('username', $request->username)->first();

        $requestList = \App\RequestResetPassword::where('user_id', $user->id)
            ->where('status', 0)->get();
        if ($requestList) {
            foreach ($requestList as $key => $value) {
                $value->status = 3;
                $value->save();
            }
        }
        if ($user) {
            $limit = null;
            if ((int)$request->activation === 1) {
                $admin = 1000;
                // $user->password=bcrypt($request->new_password);
                // $user->actived=1;
                $id = $this->getTransactionId();
                $limit = date("Y-m-d H:i:s", time() + 300);
                $requestReset = $user->request_reset_passwords()->create([
                    'otp' => $id,
                    'new_password' => bcrypt($request->new_password),
                    'admin' => $admin,
                    'activation' => 1,
                    'expired' => $limit
                ]);
                $param = [
                    'rqid' => 'Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT',
                    'mmid' => 'mastersip',
                    'app' => 'transaction',
                    'action' => 'send_sms',
                    'nohp' => trim($user->address->phone),
                    'pesan' => 'Kode OTP adalah ' . $id . ' . Berlaku sampai ' . date('d-m-Y H:i', strtotime($limit)) . ' WIB. JANGAN MEMBERIKAN KODE OTP ANDA KEPADA SIAPAPUN. Pakai SIP, Pasti SIP'
                ];
                $param = json_encode($param);
                $sms = SipSms::send($param)->get();
                if ($sms['error_code'] != '000') {
                    $requestReset->status = 4;
                    $requestReset->save();
                    return [
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => 'Failed send OTP to member'
                        ]
                    ];
                }
            } else {
                $admin = 1000;
                $check = Deposit::check($user->id, $admin)->get();
                if (!$check) {
                    return [
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => 'Failed change password, your balance not anough.'
                        ]
                    ];
                }
                $id = $this->getTransactionId();
                $idRrp = substr("" . time(), -4) . strrev($id) . rand(10, 99);
                $debit = Deposit::debit($user->id, $admin, 'rrp|' . $idRrp . "|Debit SMS reset password IDR 1.000")->get();
                if ($debit['status']['code'] != 200) {
                    return [
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => 'Failed change password, Debit deposit failed.'
                        ]
                    ];
                }
                $limit = date("Y-m-d H:i:s", time() + 300);
                $requestReset = $user->request_reset_passwords()->create([
                    'otp' => $id,
                    'new_password' => bcrypt($request->new_password),
                    'admin' => $admin,
                    'expired' => $limit
                ]);
                $param = [
                    'rqid' => 'Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT',
                    'mmid' => 'mastersip',
                    'app' => 'transaction',
                    'action' => 'send_sms',
                    'nohp' => trim($user->address->phone),
                    'pesan' => 'Kode OTP adalah ' . $id . ' . Berlaku sampai ' . date('d-m-Y H:i', strtotime($limit)) . ' WIB. JANGAN MEMBERIKAN KODE OTP ANDA KEPADA SIAPAPUN. Pakai SIP, Pasti SIP'
                ];
                $param = json_encode($param);
                $sms = SipSms::send($param)->get();
                if ($sms['error_code'] != '000') {
                    $credit = Deposit::credit($user->id, $admin, 'rrp|' . $idRrp . "|Refund failed SMS reset password IDR 1.000")->get();
                    $requestReset->status = 4;
                    $requestReset->save();
                    return [
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => 'Failed send OTP to member'
                        ]
                    ];
                }
            }
            return [
                'status' => [
                    'code' => 200,
                    'confirm' => 'success',
                    'message' => date('d-M-y H:i:s', strtotime($limit)) . ' WIB.'
                ]
            ];
        }
        return [
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => 'Username not found !'
            ]
        ];
    }

    public function confirmSetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            'otp' => 'required|exists:request_reset_passwords,otp'
        ]);
        if ($validator->fails()) {
            return [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => 'Kode otp yang Anda masukan salah'
                ]
            ];
        }
        $date = date('Y-m-d', time());
        $user = User::where('username', $request->username)->first();
        $requestReset = \App\RequestResetPassword::where('otp', $request->otp)
            ->where('user_id', $user->id)->where('confirmed', 0)->where('status', 0)->where('created_at', 'like', $date . '%')->first();
        if (!$requestReset) {
            return [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => 'OTP salah / sudah kadaluarsa.'
                ]
            ];
        }
        DB::beginTransaction();
        try {
            $user->password = $requestReset->new_password;
            $user->suspended = 0;
            if ($requestReset->activation === 1) {
                $user->actived = 1;
                $user->pin_attempt_granted = 5;
                $user->pin = NULL;
            }
            $user->save();
            $requestReset->confirmed = 1;
            $requestReset->status = 1;
            $requestReset->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('Confirm set password Failed. Error: ' . $e->getMessage());
            return [
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => 'Process reset password failed.'
                ]
            ];
        }
        DB::commit();
        return [
            'status' => [
                'code' => 200,
                'confirm' => 'success',
                'message' => 'Reset password success.'
            ]
        ];
    }

    private function getTransactionId()
    {
        $i = 1;
        $transactionId = null;
        $date = date('Y-m-d', time());
        while (true) {
            $transactionId = $i . substr("" . time(), -3);
            if (\App\RequestResetPassword::where('otp', $transactionId)->where('created_at', 'LIKE', $date . '%')->first() === null) {
                break;
            }
            $i++;
        }
        return $transactionId;
    }
}
