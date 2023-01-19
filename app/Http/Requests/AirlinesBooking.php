<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AirlinesBooking extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'acDep'=>'required|exists:airlines_codes,code',
            'org'=>'required|exists:airports,id',
            'des'=>'required|exists:airports,id',
            'flight'=>'required|exists:trip_types,id',
            'tgl_dep'=>'required',
            'adt'=>'required|numeric',
            'chd'=>'required|numeric',
            'inf'=>'required|numeric',
            'selectedIDdep'=>'required',
            'bookStat'=>'required',
            'buyName'=>'required',
            'buyPhone'=>'required|numeric',
            'buyEmail'=>'required|email',
            'adtFirstName'=>'required',
            'adtLastName'=>'required',
            'adtPhone'=>'required'
        ];
    }

//    public function messages(){
//
//    }
}
