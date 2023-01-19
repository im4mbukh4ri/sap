<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AirlinesTransaction;
use Illuminate\Support\Facades\App;
use Mail;

class EmailsController extends Controller
{
    public function airlinesMail(Request $request,$id){
      $this->validate($request,[
        'email'=>'required|email'
      ]);
      $service_fee=0;
      if($request->has('service_fee')&&$request->service_fee!=""){
          $service_fee=$request->service_fee;
      }
      $transaction=AirlinesTransaction::find($id);
      $transaction->service_fee=$service_fee;
      //return view('partials.receipts.airlines.e-ticket',compact('transaction'));
      Mail::send('emails.e-ticket',[],function ($m) use ($transaction,$request){
          $pdf = App::make('dompdf.wrapper');
          $pdf->loadView('partials.receipts.airlines.e-ticket2',['transaction'=>$transaction]);
          $m->from('eticket@smartinpays.com','e-Ticket Smart In Pays');
          $m->to($request->email,'Smart People')->subject('e-Ticket Smart In Pays');
          $m->attachData($pdf->output(),$transaction->id.".pdf",['mime'=>'application/pdf']);
      });
      return redirect()->back();
    }
}
