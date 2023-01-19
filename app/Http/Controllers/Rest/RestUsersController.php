<?php

namespace App\Http\Controllers\Rest;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class RestUsersController extends Controller
{
    //
    public function index(){

        return Response::json([
            'status'=>[
                'code'=>400,
                'confirm'=>'failed',
                'message'=>'username tidak boleh kosong'
            ],
            'detail'=>[
                'user'=>null
            ]
        ]);
    }

    public function show($username){
        $user =  User::where('username',$username)->first();
        if($user){

            return Response::json([
                'status'=>[
                    'code'=>200,
                    'confirm'=>'success',
                    'message'=>''
                ],
                'detail'=>[
                    'user'=>$user
                ]
            ]);
        }
        return Response::json([
            'status'=>[
                'code'=>400,
                'confirm'=>'failed',
                'message'=>'Data tidak ditemukan.'
            ],
            'detail'=>[
                'user'=>null
            ]
        ]);
    }
}
