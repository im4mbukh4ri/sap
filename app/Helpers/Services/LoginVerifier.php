<?php
namespace App\Helpers\Services;


use Illuminate\Support\Facades\Auth;

class LoginVerifier
{
    public function verify($username,$password){
        $credentials=[
            'username'=>$username,
            'password'=>$password
        ];
        if (Auth::once($credentials)){
            return true;
        }
        return false;
    }
}