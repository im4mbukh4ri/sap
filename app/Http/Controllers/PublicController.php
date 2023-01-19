<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PublicController extends Controller
{
    public function termsEn()
    {
        return view('public.terms-en');
    }
    public function termsId()
    {
        return view('public.terms-id');
    }
}
