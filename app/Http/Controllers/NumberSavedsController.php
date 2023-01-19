<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\NumberSaved;

class NumberSavedsController extends Controller
{
    public function __construct(){
      $this->middleware(['auth','csrf']);
    }
    public function index(Request $request){
      $user=$request->user();
      return view('autodebits.number-saved',compact('user'));
    }
    public function store(Request $request){
      $this->validate($request,[
        'service'=>'required|exists:ppob_services,id',
        'ppob_service_id'=>'required|exists:ppob_services,id',
        'name'=>'required',
        'number'=>'required'
      ]);
      if(NumberSaved::where('user_id',$request->user()->id)->where('service',$request->service)->count()<10){
        $data=$request->only('service','ppob_service_id','name','number');
        $data['id']=$this->generateId();
        $data['user_id']=$request->user()->id;
        $saveNumber=NumberSaved::create($data);
        flash()->overlay('Berhasil menambahkan nomor.','INFO');
        return redirect()->back();
      }
      flash()->overlay('Gagal menambahkan nomor.Kuota penyimpanan yang Anda pilih sudah penuh.','INFO');
      return redirect()->back();
    }
    public function destroy(Request $request){
      $numberSaved=NumberSaved::find($request->id);
      if($numberSaved){
        $numberSaved->delete();
        flash()->overlay('Berhasil hapus nomor.','INFO');
        return redirect()->back();
      }
      return redirect()->back();
    }
    public function update(Request $request){
      $this->validate($request,[
        'name'=>'required'
      ]);
      $numberSaved=NumberSaved::find($request->id);
      if($numberSaved){
        $numberSaved->name=$request->name;
        $numberSaved->save();
        flash()->overlay('Berhasil edit data.','INFO');
        return redirect()->back();
      }
      return redirect()->back();
    }
    public function generateId(){
      $i=1;
      $numberId=null;
      while (true){
          $numberId=$i.substr("".time(),-4);
          if(NumberSaved::find($numberId)===null){
              break;
          }
          $i++;
      }
      return $numberId;
    }
}
