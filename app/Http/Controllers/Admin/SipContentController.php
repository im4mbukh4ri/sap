<?php

namespace App\Http\Controllers\Admin;

use App\SipContent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SipContentController extends Controller
{
    //
    public function index(){
        $faqs=[];
        $faqs[]=["category" => "General", "contents" => SipContent::whereBetween('id',[1,53])->get()];
        $faqs[]=["category" => "Deposit", "contents" => SipContent::whereBetween('id',[54,63])->orWhere('id',122)->orWhere('id',123)->get()];
        $faqs[]=["category" => "Airlines", "contents" => SipContent::whereBetween('id',[64,76])->orWhere('id',93)->orWhere('id',94)->get()];
        $faqs[]=["category" => "PPOB", "contents" => SipContent::whereBetween('id',[77,78])->get()];
        $faqs[]=["category" => "Login", "contents" => SipContent::whereBetween('id',[83,86])->get()];
        $faqs[]=["category" => "Free User", "contents" => SipContent::whereBetween('id',[113,120])->get()];
        $contents = SipContent::all();
        return view('admin.sip-contents.index', compact('contents','faqs'));
    }
    public function store(Request $request){
        $this->validate($request,[
            'title'=>'required',
            'value'=>'required'
        ]);
        $contents=new SipContent();
        $contents->title=$request->title;
        $contents->content=$request->value;
        $contents->save();
        flash()->overlay('Berhasil','INFO');
        return redirect()->back();

    }
    public function edit($id){
        $content=SipContent::find($id);
        return view('admin.sip-contents.edit',compact('content'));
    }
    public function update(Request $request, $id){
        $this->validate($request,[
            'title'=>'required',
            'value'=>'required'
        ]);
        $content=SipContent::find($id);
        $content->title=$request->title;
        $content->content=$request->value;
        $content->save();
        flash()->overlay('Berhasil update','INFO');
        return redirect()->refresh();

    }
}
