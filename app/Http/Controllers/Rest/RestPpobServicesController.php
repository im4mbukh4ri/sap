<?php

namespace App\Http\Controllers\Rest;

use App\PpobService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class RestPpobServicesController extends Controller
{
    //
    public function index(Request $request){
        $service_id=0;
        $status=1;
        if ($request->has('service_id')) $service_id=$request->service_id;
        if ($request->has('status')) $status=$request->status;
        $services=PpobService::where('parent_id',$service_id)->where('status',$status)->get();
        return Response::json([
            'status'=>[
                'code'=>200,
                'confirm'=>'success',
                'message'=>'Success get data ppob service'
            ],
            'detail'=>[
                'services'=>$services
            ]
        ]);
    }
}
