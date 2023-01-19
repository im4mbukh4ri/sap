<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\NumberSaved;
use Response;

class RestNumberSavedsController extends Controller
{
    public function search(Request $request){
      $userId=$request->user()->id;
      $numbers=NumberSaved::where('user_id',$userId)->where('service',$request->service)
      ->where('number','LIKE','%'.$request->number.'%')->get();
      return $numbers;
    }
    public function find($number_saved_id){
      $number = NumberSaved::find($number_saved_id);
      if($number){
        return Response::json([
            'status'=>[
                'code'=>200,
                'message'=>['success get number']
            ],
            'details'=>[
                'number'=>$number
            ]
        ],200);
      }
      return Response::json([
          'status'=>[
              'code'=>400,
              'message'=>['failed get number']
          ]
      ],400);
    }
}
