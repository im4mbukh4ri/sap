<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HistoryPoint;
use JavaScript;

class PointsController extends Controller
{
    public function pointHistory(Request $request)
    {
      $from=date('Y-m-d',time());
      $until=$from;
      $histories=array();
      if($request->has('from')&&$request->has('until')){
          $from=date('Y-m-d',strtotime($request->from));
          $until=date('Y-m-d',strtotime($request->until));
          if(daysDifference($until,$from)<31){
              $histories = HistoryPoint::whereBetween('created_at',[$from.' 00:00:00',$until.' 23:59:59'])->get()->sortByDesc('id');
              $request->flash();
          }else{
              flash()->overlay('History point yang bisa Anda cek maksimal 31 hari.','INFO');
              return redirect()->back();
          }
      }else{
        $histories = HistoryPoint::whereBetween('created_at',[$from.' 00:00:00',$until.' 23:59:59'])->get()->sortByDesc('id');
      }
      $from=date('d-m-Y',strtotime($from));
      $until=date('d-m-Y',strtotime($until));
      JavaScript::put([
          'request'=>[
              'from'=>$from,
              'until'=>$until
          ]
      ]);
      return view('admin.points.history-point',compact('histories'));
    }
}
