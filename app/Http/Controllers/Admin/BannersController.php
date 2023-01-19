<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManager;
use League\Flysystem\Exception;

class BannersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('csrf');
    }

    public function index(){
        $banners=Banner::all();
        return view('admin.banners.index',compact('banners'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'banner'=>'required|mimes:jpg,jpeg,png'
        ]);
        $banner = $request->file('banner');
        if($banner->isValid()){
            $originalName = $banner->getClientOriginalName();
            $extension = $banner->getClientOriginalExtension();
            $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
            $fileName = $this->sanitize($originalNameWithoutExt);
            $allowedFileName = $this->createUniqueFilename($fileName,$extension);
            $uploadSuccess = $this->upload($banner,$allowedFileName);
            if( !$uploadSuccess){
                flash()->overlay('Gagal upload banner. <br> Periksa kembali file yang Anda upload.','INFO');
                return redirect()->route('admin.banners_index');
            }
            $urlBanner=$this->generateURL($allowedFileName);
            $banner = new Banner();
            $banner->file_name=$allowedFileName;
            $banner->url_banner=$urlBanner;
            $banner->save();
            flash()->overlay('Banner berhasil di upload.','INFO');
            return redirect()->route('admin.banners_index');
        }
        flash()->overlay('Gagal upload banner.<br>Periksa kembali file yang Anda upload.','INFO');
        return redirect()->route('admin.banners_index');
    }
    public function destroy(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:banners,id'
        ]);
        $banner=Banner::find($request->id);
        $delete=$this->delete($banner->file_name);
        if($delete){
            $banner->delete();
            flash()->overlay('Banner berhasil dihapus.','INFO');
            return redirect()->route('admin.banners_index');
        }
        flash()->overlay('Gagal hapus banner. Terjadi kesalahan pada sistem.','INFO');
        return redirect()->route('admin.banners_index');

    }
    public function update(Request $request){
        $this->validate($request,[
            'id'=>'required|exists:banners,id'
        ]);
        $banner=Banner::find($request->id);
        if($banner->status===1){
            $banner->status=0;
            $banner->save();
            return redirect()->route('admin.banners_index');
        }
        $banner->status=1;
        $banner->save();
        return redirect()->route('admin.banners_index');
    }
    public function upload( $logo, $fileName){
        try{
            $manager = new ImageManager();
            $image = $manager->make( $logo )->save(Config::get('sip-config.banner_dir').$fileName);
        }catch (Exception $e){
            flash()->overlay('Terjadi kesalahan.<br>Error : '.$e,'INFO');
            return redirect()->route('admin.banners_index');
        }
        return $image;
    }
    public function delete($fileName)
    {
        $dir = Config::get('sip-config.banner_dir');
        $full_path = $dir . $fileName;
        if ( File::exists( $full_path ) )
        {
            File::delete( $full_path );
        }
        return true;
    }
    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
    public function createUniqueFilename( $filename, $extension )
    {
        $banner_dir = Config::get('sip-config.banner_dir');
        $banner_path = $banner_dir . $filename . '.' . $extension;
        if ( File::exists( $banner_path ) )
        {
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }
        return $filename . '.' . $extension;
    }
    function generateURL($filename)
    {
        $url=URL::to('/').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'banners'
            .DIRECTORY_SEPARATOR.'mobile'.DIRECTORY_SEPARATOR.$filename;
        return $url;
    }
}
