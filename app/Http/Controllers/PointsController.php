<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use JavaScript;

class PointsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','csrf']);
    }
    public function pointHistory(Request $request){
        $from=date('Y-m-d',time());
        $until=$from;
        if($request->has('from')&&$request->has('until')){
            $from=date('Y-m-d',strtotime($request->from));
            $until=date('Y-m-d',strtotime($request->until));
            if(daysDifference($until,$from)<31){
                $histories = $request->user()->history_points()
                    ->whereBetween('created_at',[$from.' 00:00:00',$until.' 23:59:59'])->get()->sortByDesc('id');
                $request->flash();
            }else{
                flash()->overlay('History deposit yang bisa Anda cek maksimal 31 hari.','INFO');
                return redirect()->back();
            }
        }else{
            $histories = $request->user()->history_points()
                ->whereBetween('created_at',[$from.' 00:00:00',$until.' 23:59:59'])->get()->sortByDesc('id');
        }
        $from=date('d-m-Y',strtotime($from));
        $until=date('d-m-Y',strtotime($until));
        JavaScript::put([
            'request'=>[
                'from'=>$from,
                'until'=>$until
            ]
        ]);
        return view('points.histories.index',compact('histories'));
    }
}
