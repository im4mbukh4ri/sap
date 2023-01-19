<?php

/**
 * Created by PhpStorm.
 * User: dhaniemubarak
 * Date: 06/10/16
 * Time: 16:35
 */

namespace App\Http\Controllers\Api;


use App\Address;
use App\HistoryDeposit;
use App\Http\Controllers\Controller;
use App\TravelAgent;
use App\User;
use App\UserBank;
use App\UserLog;
use App\UserReferral;
use App\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    /*
     * API Registration
     *
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            //'member_address'=>'required',
            //'member_subdistrict_id'=>'required',
            'member_phone' => 'required',
            //'travel_address'=>'required',
            //'travel_subdistrict_id'=>'required',
            //'travel_phone'=>'required',
            //'travel_name'=>'required',
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'birth_date' => 'required',
            'type' => 'required',
            'gender' => 'required',
            //'bank_name'=>'required',
            //'rek_number'=>'required',
            //'owner_name'=>'required'
        ]);

        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors(),
                ]
            ], 400);
        }
        $type_user_id = null;
        switch ($request->type) {
            case 'basic':
                $type_user_id = 2;
                break;
            case 'advance':
                $type_user_id = 3;
                break;
            case 'pro':
                $type_user_id = 4;
                break;
            case 'starter':
                $type_user_id = 6;
                break;
            case 'pro minus':
                $type_user_id = 7;
                break;
            default:
                return Response::json([
                    'status' => [
                        'code' => 400,
                        'confirm' => 'failed',
                        'message' => ['type member invalid. Type only : basic , advance,pro, & pro minus'],
                    ]
                ], 400);
                break;
        }

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

            $member_address->user()->save($user = new User([
                'username' => $request->username,
                'name' => $request->name,
                'email' => strtolower($request->email),
                'password' => bcrypt($request->password),
                'type' => $request->type,
                'role' => $request->type,
                'gender' => $request->gender,
                'birth_date' => $request->birth_date,
                'upline' => 1,
                'actived' => 1,
                'type_user_id' => $type_user_id
            ]));

            $user->referral()->save($ref = new UserReferral([
                'referral' => $this->getReferral()
            ]));
            //            $user->banks()->save(new UserBank([
            //                'bank_name'=>$request->bank_name,
            //                'number'=>$request->rek_number,
            //                'owner_name'=>$request->owner_name
            //            ]));

            $user->travel_agent()->save(new TravelAgent([
                'name' => 'Isi nama travel Anda disini',
                'address_id' => $travel_address->id,
            ]));

            //            $user->history_deposits()->save(new HistoryDeposit([
            //                'note'=>'Deposit awal Rp0'
            //            ]));
            $quantity = 10;
            if ($user->role === 'basic') {
                $quantity = 40;
            } elseif ($user->role === 'advance') {
                $quantity = 200;
            } elseif ($user->role === 'pro') {
                $quantity = 500;
            } elseif ($user->role === 'pro minus') {
                $quantity = 500;
            }

            \App\UserVoucher::create([
                'user_id' => $user->id,
                'voucher_id' => 1,
                'quantity' => $quantity
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => ['error'],
                ]
            ], 400);
        }
        DB::commit();

        return Response::json([
            'status' => [
                'code' => 200,
                'confirm' => 'success',
                'message' => ['Berhasil registrasi'],
            ],
            'details' => [
                'data' => $request->all(),
                'referral' => $ref->referral
            ]
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:users,username',
            //'old_type'=>'required',
            'new_type' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => $validator->errors()
                ]
            ]);
        }
        $type = ['basic' => 2, 'advance' => 3, 'pro' => 4, 'free' => 5, 'starter' => 6];
        if (array_key_exists(strtolower($request->new_type), $type)) {
            $user = User::where('username', $request->username)->first();
            $oldType = $user->role;
            $newType = strtolower($request->new_type);
            $ref = $user->referral;
            DB::beginTransaction();
            try {
                UserLocation::where('user_id', '=', $user->id)->update(['type_user_id' => $type[$request->new_type]]);
                $user->type = $request->new_type;
                $user->role = $request->new_type;
                $user->type_user_id = $type[$request->new_type];
                $user->upline = 1;
                $user->save();
                //                if($oldType=='free'){
                //                    $user->referral()->save($ref = new UserReferral([
                //                        'referral'=>$this->getReferral()
                //                    ]));
                //                }
                $user->logs()->save(new UserLog([
                    'log' => 'Berhasil update tipe member ' . $oldType . ' ke ' . $newType
                ]));
            } catch (Exception $e) {
                DB::rollback();
                $user->logs()->save(new UserLog([
                    'log' => 'Gagal update tipe member ' . $oldType . ' ke ' . $newType . '. Error: ' . $e->getMessage()
                ]));
                return Response::json([
                    'status' => [
                        'code' => 400,
                        'confirm' => 'failed',
                        'message' => $validator->errors()
                    ]
                ]);
            }
            DB::commit();
            return Response::json([
                'status' => [
                    'code' => 200,
                    'confirm' => 'success',
                    'message' => ['Berhasil update tipe member.']
                ],
                'details' => [
                    'data' => $request->all(),
                    //'referral'=>$ref->referral
                ]
            ]);
        }
        return Response::json([
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => [
                    'Tipe member yang Anda kirim tidak terdaftar. Periksa kembali tipe member (new_type)',
                    'Tipe member : basic, advance, pro, free'
                ]
            ]
        ]);
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
}
