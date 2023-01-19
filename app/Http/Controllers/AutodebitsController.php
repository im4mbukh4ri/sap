<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\NumberSaved;
use App\Autodebit;

class AutodebitsController extends Controller
{
    //
    public function __construct(){
      $this->middleware(['auth','active:1','csrf']);
    }
    public function index(Request $request){
      $user=$request->user();
      return view('autodebits.index',compact('user'));
    }
    public function store(Request $request){
      $this->validate($request,[
        'date'=>'required'
      ]);
      $numberSaved=NumberSaved::find($request->number_save_id);
      if(!$numberSaved->autodebit){
        if($numberSaved->service===2){
          $numberSaved->ppob_service_id=$request->ppob_service_id;
          $numberSaved->save();
        }
        $numberSaved->autodebit()->create([
          'id'=>$this->getNumberId(),
          'user_id'=>$numberSaved->user_id,
          'date'=>$request->date
        ]);
        flash()->overlay('Berhasil menambahkan nomor ke Autodebet.','INFO');
        return redirect()->back();
      }
      flash()->overlay('Maaf nomor tersebut sudah terdaftar di Autodebet','INFO');
      return redirect()->back();
    }
    public function delete(Request $request){
      $autodebit=Autodebit::find($request->id);
      if($autodebit){
        $autodebit->delete();
        flash()->overlay("Berhasil hapus autodebit.","INFO");
        return redirect()->back();
      }
      flash()->overlay("Terjadi kesalahan. Data tidak ditemukan.","INFO");
      return redirect()->back();
    }
    private function getNumberId(){
        $i=1;
        $numberId=null;
        while (true){
            $numberId=$i.substr("".time(),-3);
            if(\App\NumberSaved::find($numberId)===null){
                break;
            }
            $i++;
        }
        return $numberId;
    }
}
