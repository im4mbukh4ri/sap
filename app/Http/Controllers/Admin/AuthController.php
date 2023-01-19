<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


    protected $redirectTo = '/admin';
    protected $username = 'username';

    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function username()
    {
        return 'username';
    }
}
