<?php

namespace App\Http\Controllers\Admin;

use App\Announcement;
use App\AnnouncementPicture;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnnouncementsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth','csrf']);
    }

    public function index(){
        $announcements=Announcement::all();
        return view('admin.announcements.index',compact('announcements'));
    }

    public function create(Request $request){
        $this->validate($request,[
            'title'=>'required',
        ]);
        DB::beginTransaction();
        try{
            $announcement = Announcement::create($request->only('title','content'));
            if($request->hasFile('picture')){
                $this->validate($request,[
                    'picture'=>'mimes:jpeg,bmp,png,jpg'
                ]);
                $data=$this->savePicture($request->picture);
                $announcement->picture()->save($picture = new AnnouncementPicture($data));
            }
        }catch (\Exception $e){
            DB::rollback();
            Log::info('Failed create announcement, error:'.$e->getMessage());
            flash()->overlay('Terjadi kesalahan, berita gagal diposting.','INFO');
            return redirect(route('admin.announcements_index'));
        }
        DB::commit();
        flash()->overlay('Berita berhasil diposting.','INFO');
        return redirect(route('admin.announcements_index'));
    }

    public function edit($id){
        $announcements=Announcement::all();
        $announcement=Announcement::find($id);
        return view('admin.announcements.edit',compact('announcements','announcement'));
    }

    public function update(Request $request,$id){
        $announcement=Announcement::find($id);
        $announcement->title=$request->title;
        $announcement->content=$request->get('content');
        $announcement->save();

        if($request->hasFile('picture')){
            $this->validate($request,[
                'picture'=>'mimes:jpeg,bmp,png,jpg'
            ]);
            if($announcement->picture){
                $this->deletePicture($announcement->picture->file_name);
                $data=$this->savePicture($request->picture);
                $announcement->picture->file_name=$data['file_name'];
                $announcement->picture->url=$data['url'];
                $announcement->picture->save();
            }else{
                $data=$this->savePicture($request->picture);
                $announcement->picture()->save($picture = new AnnouncementPicture($data));
            }
        }
        flash()->overlay('Berita berhasil diupdate.','INFO');
        return redirect(route('admin.announcements_index'));

    }

    public function destroy($id){
        $announcement=Announcement::find($id);
        if($announcement->picture){
            $this->deletePicture($announcement->picture->file_name);
            $announcement->picture->delete();
        }
        $announcement->delete();
        flash()->overlay('Berita berhasil dihapus.','INFO');
        return redirect(route('admin.announcements_index'));
    }

    protected function savePicture(UploadedFile  $photo){
        $destinationPath=public_path().DIRECTORY_SEPARATOR.'images'
            .DIRECTORY_SEPARATOR.'announcements';
        $fileName=str_random(10).'.'.$photo->guessClientExtension();
        $url =URL::to('/').DIRECTORY_SEPARATOR.'images'
            .DIRECTORY_SEPARATOR.'announcements'.DIRECTORY_SEPARATOR.$fileName;
        $photo->move($destinationPath,$url);
        return [
            'file_name'=>$fileName,
            'url'=>$url
        ];
    }
    protected function deletePicture($filename){
        $path=public_path().DIRECTORY_SEPARATOR.'images'
            .DIRECTORY_SEPARATOR.'announcements'.DIRECTORY_SEPARATOR.$filename;
        return  File::delete($path);
    }
}
