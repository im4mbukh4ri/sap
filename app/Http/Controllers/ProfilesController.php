<?php

namespace App\Http\Controllers;

use App\OauthClient;
use App\OauthClientSecret;
use App\TravelAgent;
use App\User;
use App\UserPhoto;
use App\UserLocation;
use App\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManager;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'csrf']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $userphoto = UserPhoto::where('user_id', '=', $request->user()->id)->first();
        return view('profiles.index', compact('user', 'userphoto'));
    }

    public function updateTravel(Request $request, $travel_id)
    {
        $credentials = ['username' => $request->user()->username, 'password' => $request->CaptchaCode];
        $userLogin = Auth::once($credentials);
        if ($userLogin) {
            $this->validate($request, [
                'travel_id' => 'required|exists:travel_agents,id',
                'name' => 'required',
                'email' => 'required|email',
                'detail' => 'required',
                'subdistrict_id' => 'required',
                'phone' => 'required',
            ]);
            $travel = TravelAgent::find($travel_id);
            $travel->name = $request->name;
            $travel->email = $request->email;
            $travel->save();
            $travel->address->detail = $request->detail;
            $travel->address->subdistrict_id = $request->subdistrict_id;
            $travel->address->phone = $request->phone;
            $travel->address->save();

            flash()->overlay('Berhasil Memperbaharui profil travel', 'INFO');
            return redirect()->route('profiles.index');
        }
        flash()->overlay('Password yang Anda masukan salah', 'INFO');
        return redirect()->route('profiles.index');
    }

    public function updateUser(Request $request, $user_id)
    {
        $credentials = ['username' => $request->user()->username, 'password' => $request->CaptchaCodeLogin];
        $userLogin = Auth::once($credentials);
        if ($userLogin) {
            $this->validate($request, [
                'name' => 'required',
                'detail' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required',
            ]);

            $user = User::find($user_id);
            $user->name = $request->name;
            $user->save();
            $user->address->detail = $request->detail;
            $user->address->subdistrict_id = $request->subdistrict_id;
            $user->address->save();
            flash()->overlay('Berhasil Memperbaharui profil', 'INFO');
            return redirect()->route('profiles.index');
        }
        flash()->overlay('Password yang Anda masukan salah', 'INFO');
        return redirect()->route('profiles.index');
    }
    public function updatePassword(Request $request, $user_id)
    {
        $code = $request->CaptchaCodeReset;
        $isHuman = captcha_validate($code);
        if ($isHuman) {
            $this->validate($request, [
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);
            $user = User::find($user_id);
            if (Auth::attempt(['username' => $user->username, 'password' => $request->old_password])) {
                $user->password = bcrypt($request->new_password);
                $user->save();
                flash()->overlay('Berhasil Mengganti password', 'INFO');
                return redirect()->route('profiles.index');
            }
            flash()->overlay('Gagal mengganti password. Password lama yang Anda masukan salah.', 'INFO');
            return redirect()->route('profiles.index');
        }
        flash()->overlay('Kode akses yang Anda masukan salah', 'INFO');
        return redirect()->route('profiles.index');
    }
    public function updateLogo(Request $request, $travel_id)
    {
        $hasLogo = $request->hasFile('logo');
        if ($hasLogo) {
            $this->validate($request, [
                'logo' => 'mimes:jpeg,jpg,bmp,png',
            ]);
            $travel = TravelAgent::find($travel_id);
            $logo = $request->file('logo');
            $originalName = $logo->getClientOriginalName();
            $extension = $logo->getClientOriginalExtension();
            $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
            $fileName = $this->sanitize($originalNameWithoutExt);
            $allowedFileName = $this->createUniqueFilename($fileName, $extension);
            $uploadSuccess = $this->upload($logo, $allowedFileName);
            if (!$uploadSuccess) {
                flash()->overlay('Gagal mengganti logo travel. <br> Periksa kembali file yang Anda upload', 'INFO');
                return redirect()->route('profiles.index');
            }
            if ($travel->url_logo != '') {
                $explode = explode('/', $travel->url_logo);
                $this->delete($explode[5]);
            }
            $travel->url_logo = $this->generateURL($allowedFileName);
            $travel->save();
            flash()->overlay('Berhasil Memperbaharui logo travel', 'INFO');
            return redirect()->route('profiles.index');
        }
        flash()->overlay('Tidak ada logo file yang Anda pilih', 'INFO');
        return redirect()->route('profiles.index');
    }
    public function updatePhoto(Request $request, $user_id)
    {
        $hasPhoto = $request->hasFile('photo');
        if ($hasPhoto) {
            $this->validate($request, [
                'photo' => 'mimes:jpeg,jpg,bmp,png|max:50',
            ]);
            $userphoto = UserPhoto::where('user_id', '=', $user_id)->first();
            $photo = $request->file('photo');
            $originalName = $photo->getClientOriginalName();
            $extension = $photo->getClientOriginalExtension();
            $originalNameWithoutExt = substr($originalName, 0, strlen($originalName) - strlen($extension) - 1);
            $fileName = $this->sanitize($originalNameWithoutExt);
            $allowedFileName = $this->createUniqueFilenamePhoto($fileName, $extension);
            $uploadSuccess = $this->uploadFoto($photo, $allowedFileName);
            if (!$uploadSuccess) {
                flash()->overlay('Gagal mengganti foto profil. <br> Periksa kembali file yang Anda upload', 'INFO');
                return redirect()->route('profiles.index');
            }
            if ($userphoto == null) {
                $newuserphoto = new UserPhoto;
                $newuserphoto->user_id = $user_id;
                $newuserphoto->url_photo = $this->generateURLPhoto($allowedFileName);
                $newuserphoto->file_name = $allowedFileName;
                $newuserphoto->save();
            } else {
                $this->deletePhoto($userphoto->file_name);
                $userphoto->url_photo = $this->generateURLPhoto($allowedFileName);
                $userphoto->file_name = $allowedFileName;
                $userphoto->save();
            }

            flash()->overlay('Berhasil Memperbaharui foto profil', 'INFO');
            return redirect()->route('profiles.index');
        }
        flash()->overlay('Tidak ada file foto profil yang Anda pilih', 'INFO');
        return redirect()->route('profiles.index');
    }
    public function shareLocation(Request $request, $user_id)
    {
        $credentials = ['username' => $request->user()->username, 'password' => $request->password];
        $userLogin = Auth::once($credentials);
        if ($userLogin) {
            if ($request->has('location_android') && $request->has('show_on_map_android')) {
                $this->validate($request, [
                    'location_android' => 'required|numeric',
          'show_on_map_android' => 'required|numeric',
                ]);
                UserLocation::where('user_id', '=', $user_id)->where('device', '=', 'android')->update(['share_location' => $request->location_android]);
                UserLocation::where('user_id', '=', $user_id)->where('device', '=', 'android')->update(['show_on_map' => $request->show_on_map_android]);
            }
            if ($request->has('location_ios') && $request->has('show_on_map_ios')) {
                $this->validate($request, [
                    'location_ios' => 'required|numeric',
          'show_on_map_ios' => 'required|numeric',
                ]);
                UserLocation::where('user_id', '=', $user_id)->where('device', '=', 'ios')->update(['share_location' => $request->location_ios]);
                UserLocation::where('user_id', '=', $user_id)->where('device', '=', 'ios')->update(['show_on_map' => $request->show_on_map_ios]);
            }
            flash()->overlay('Berhasil Memperbaharui Konfigurasi', 'INFO');
            return redirect()->route('profiles.index');
        }
        flash()->overlay('Password yang Anda masukan salah', 'INFO');
        return redirect()->route('profiles.index');
    }
    public function resetDevice(Request $request, $device_id)
    {
        $device = OauthClientSecret::where('device_id', $device_id)->first();
        if (!$device) {
            flash()->overlay('Terjadi kesalahan. Error : Device id not found', 'INFO');
            return redirect()->route('profiles.index');
        }
        DB::beginTransaction();
        try {
            $client = OauthClient::where('id', $device->client_id)->first();
            $user = $request->user();
            DB::table('user_locations')->where('user_id', $user->id)->where('device', $device->device_type)->delete();
            $user->logs()->save(new UserLog(['log' => 'Berhasil reset device. Device : ' . $device->device_type . ' , Device id : ' . $device_id]));
            if ($client) {
                $client->delete();
            }

            $device->delete();
        } catch (\Exception $e) {
            flash()->overlay('Terjadi kesalahan. Error : ' . $e->getMessage(), 'INFO');
            return redirect()->route('profiles.index');
            DB::rollback();
        }
        DB::commit();
        flash()->overlay('Reset device berhasil', 'INFO');
        return redirect()->route('profiles.index');
    }
    public function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
        $clean;
    }
    public function upload($logo, $fileName)
    {
        $manager = new ImageManager();
        $image = $manager->make($logo)->resize(200, 200)->save(Config::get('sip-config.logo_dir') . $fileName);
        return $image;
    }
    public function uploadFoto($photo, $fileName)
    {
        $manager = new ImageManager();
        $image = $manager->make($photo)->resize(200, 200)->save(Config::get('sip-config.user_dir') . $fileName);
        return $image;
    }
    public function delete($fileName)
    {
        $logo = Config::get('sip-config.logo_dir');
        $full_path = $logo . $fileName;
        if (File::exists($full_path)) {
            File::delete($full_path);
        }
        return true;
    }
    public function deletePhoto($fileName)
    {
        $photo = Config::get('sip-config.user_dir');
        $full_path = $photo . $fileName;
        if (File::exists($full_path)) {
            File::delete($full_path);
        }
        return true;
    }
    public function createUniqueFilename($filename, $extension)
    {
        $logo_dir = Config::get('sip-config.logo_dir');
        $logo_path = $logo_dir . $filename . '.' . $extension;
        if (File::exists($logo_path)) {
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }
        return $filename . '.' . $extension;
    }
    public function createUniqueFilenamePhoto($filename, $extension)
    {
        $photo_dir = Config::get('sip-config.user_dir');
        $photo_path = $photo_dir . $filename . '.' . $extension;
        if (File::exists($photo_path)) {
            $imageToken = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $imageToken . '.' . $extension;
        }
        return $filename . '.' . $extension;
    }
    public function generateURL($filename)
    {
        $url = URL::to('/') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo'
            . DIRECTORY_SEPARATOR . 'travel' . DIRECTORY_SEPARATOR . $filename;
        return $url;
    }
    public function generateURLPhoto($filename)
    {
        $url = URL::to('/') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'user'
            . DIRECTORY_SEPARATOR . 'photo' . DIRECTORY_SEPARATOR . $filename;
        return $url;
    }
}
