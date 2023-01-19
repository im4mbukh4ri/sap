<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DocumentationsController extends Controller
{
    //
    public function index(){
        return view('api.v1.documentations.index');
    }
}
