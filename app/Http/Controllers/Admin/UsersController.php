<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\OauthClient;
use App\OauthClientSecret;
use App\TravelAgent;
use App\User;
use App\UserLog;
use App\UserLocation;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Intervention\Image\ImageManager;
use JavaScript;
use Log;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $q = $request->q;
        $type = $request->type;
        $_token = $request->_token;
        $users = User::where('username', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%')->orWhere('phone_number', 'like', '%' . $q . '%');
        if ($request->has('type')) {
            if ($request->q  == '') {
                if ($type != 0) {
                    $users = User::where('type_user_id', $type);
                } else {
                    $users = User::where('type_user_id', '<>', $type);
                }
            } else {
                if ($type != 0) {
                    $users = User::where('type_user_id', $type)->where('username', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%');
                } else {
                    $users = User::where('type_user_id', '<>', $type)->where('username', 'like', '%' . $q . '%')->orWhere('email', 'like', '%' . $q . '%');
                }
            }
        }
        $total = $users->count();
        $users = $users->paginate(50);
        $request->flash();
        return view('admin.users.index', compact('users', 'q', '_token', 'total', 'type'));
    }

    public function unverified(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);

        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Free Member Unverified yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }

        if ($request->has('export') && $request->export == '1') {
            $users = User::where('actived', '!=', 1)->where('type_user_id', '=', 5)->whereBetween('users.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
            $totalQuery = count($users);
            $while = ceil($totalQuery / 500);
            $collections = collect($users);
            return Excel::create($startDate . '_' . $endDate, function ($excel) use ($while, $collections) {
                for ($i = 1; $i <= $while; $i++) {
                    $items = $collections->forPage($i, 500);
                    Log::info($items);
                    $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                        $sheet->loadView('admin.partials._report-excel-users-unverified', ['users' => $items]);
                    });
                }
            })->export('xls');
        }

        $users = User::where('actived', '!=', 1)->where('type_user_id', '=', 5)->whereBetween('users.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $total = $users->count();
        $users = $users->paginate(50);

        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);

        return view('admin.users.unverified', compact('_token', 'users', 'startDate', 'endDate', 'statusReq', 'total'));
    }

    public function pasif(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);

        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Free Member Pasif yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }

        if ($request->has('export') && $request->export == '1') {
            $users = User::where('type_user_id', '=', 5)->where('actived', '=', 1)->leftJoin('history_deposits', 'users.id', '=', 'history_deposits.user_id')->whereBetween('users.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('history_deposits.user_id', null)->select('users.created_at', 'users.username', 'users.updated_at', 'users.name', 'users.email', 'users.upline', 'users.created_by', 'users.address_id')->get();
            $totalQuery = count($users);
            $while = ceil($totalQuery / 500);
            $collections = collect($users);
            return Excel::create($startDate . '_' . $endDate, function ($excel) use ($while, $collections) {
                for ($i = 1; $i <= $while; $i++) {
                    $items = $collections->forPage($i, 500);
                    Log::info($items);
                    $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                        $sheet->loadView('admin.partials._report-excel-users-pasif', ['users' => $items]);
                    });
                }
            })->export('xls');
        }

        $users = User::where('type_user_id', '=', 5)->where('actived', '=', 1)->leftJoin('history_deposits', 'users.id', '=', 'history_deposits.user_id')->whereBetween('users.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('history_deposits.user_id', null)->select('users.created_at', 'users.username', 'users.updated_at', 'users.name', 'users.email', 'users.upline', 'users.created_by', 'users.address_id');
        $total = $users->count();
        $users = $users->paginate(50);

        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.users.pasif', compact('_token', 'users', 'startDate', 'endDate', 'statusReq', 'total'));
    }

    public function aktif(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);

        if ($request->has('start_date') && $request->has('end_date')) {
            $this->validate($request, [
                'start_date' => 'date',
                'end_date' => 'date',
                '_token' => 'required',
            ]);
            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $_token = $request->_token;
            if (daysDifference($startDate, $endDate) > 31) {
                flash()->overlay('Free Member Aktif yang bisa Anda cek maksimal 31 hari.', 'INFO');
                return redirect()->back();
            }
        }

        if ($request->has('export') && $request->export == '1') {
            $users = User::where('type_user_id', '=', 5)
                                ->where('actived', '=', 1)
                                ->join('history_deposits', 'users.id', '=', 'history_deposits.user_id')
                                ->whereBetween('users.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                                ->select('users.created_at', 'users.username', 'users.updated_at', 'users.name', 'users.email', 'users.upline', 'users.created_by', 'users.address_id')
                                ->groupBy('users.username')->get();
            $totalQuery = count($users);
            $while = ceil($totalQuery / 500);
            $collections = collect($users);
            return Excel::create($startDate . '_' . $endDate, function ($excel) use ($while, $collections) {
                for ($i = 1; $i <= $while; $i++) {
                    $items = $collections->forPage($i, 500);
                    Log::info($items);
                    $excel->sheet('page-' . $i, function ($sheet) use ($items) {
                        $sheet->loadView('admin.partials._report-excel-users-pasif', ['users' => $items]);
                    });
                }
            })->export('xls');
        }

        $users = User::where('type_user_id', '=', 5)
                            ->where('actived', '=', 1)
                            ->join('history_deposits', 'users.id', '=', 'history_deposits.user_id')
                            ->whereBetween('users.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                            ->select('users.created_at', 'users.username', 'users.updated_at', 'users.name', 'users.email', 'users.upline', 'users.created_by', 'users.address_id')
                            ->groupBy('users.username');
        $total = count($users->get());
        $users = $users->paginate(50);

        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.users.aktif', compact('_token', 'users', 'startDate', 'endDate', 'statusReq', 'total'));
    }

    public function freeUsers()
    {
        $users = User::where('type_user_id', '=', 5);
        $total['free_member'] = $users->count();
        $users = $users->where('actived', '=', 1);
        $total['verified'] = $users->count();
        $total['unverified'] = $total['free_member'] - $total['verified'];
        $users = $users->join('history_deposits', 'users.id', '=', 'history_deposits.user_id')->groupBy('users.id')->get();
        $total['aktif'] = count($users);
        $total['pasif'] = $total['verified'] - $total['aktif'];

        return view('admin.users.free_member', compact('total'));
    }

    public function airlines(Request $request)
    {
        $startDate = date("Y-m-d", time());
        $endDate = date("Y-m-d", time());
        $statusReq = $request->status;
        $_token = str_random(40);

        $bookings = AirlinesBooking::whereBetWeen('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')->paginate(500);
        $totalAmount = DB::select("SELECT SUM(airlines_booking.paxpaid) as total_marketprice, SUM(airlines_commissions.pusat) as total_pusat, SUM(airlines_commissions.bv) as total_smartpoint, SUM(airlines_commissions.member) as total_smarcash FROM airlines_booking
  						INNER JOIN airlines_commissions ON airlines_booking.id = airlines_commissions.airlines_booking_id WHERE airlines_booking.created_at BETWEEN '{$startDate} 00:00:00' AND '{$endDate} 23:59:59' AND airlines_booking.status LIKE '%{$statusReq}%' AND status <> 'failed'");

        $request->flash();
        $startDate = date('d-m-Y', strtotime($startDate));
        $endDate = date('d-m-Y', strtotime($endDate));
        JavaScript::put([
            'request' => [
                'from' => $startDate,
                'until' => $endDate,
            ],
        ]);
        return view('admin.transactions.airlines.index', compact('_token', 'bookings', 'startDate', 'endDate', 'statusReq', 'totalAmount'));
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            // dd($user->user_location);
            return view('admin.users.show', compact('user'));
        }
        return response('Not Found', 200);
    }
    public function update(Request $request, $user_id)
    {
        $code = $request->CaptchaCodeLogin;
        $isHuman = captcha_validate($code);
        if ($isHuman) {
            $this->validate($request, [
                'name' => 'required',
                'detail' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required',
            ]);
            $user = User::find($user_id);
            $user->name = $request->name;
            // $user->email=$request->email;
            $user->save();
            $user->address->detail = $request->detail;
            $user->address->subdistrict_id = $request->subdistrict_id;
            $user->address->save();
            flash()->overlay('Berhasil Memperbaharui profil', 'INFO');
            return redirect()->route('admin.users_show', $user->id);
        }
        flash()->overlay('Kode akses yang Anda masukan salah', 'INFO');
        return redirect()->back();
    }
    public function updatePassword(Request $request, $user_id)
    {
        $code = $request->CaptchaCodeReset;
        $isHuman = captcha_validate($code);
        if ($isHuman) {
            $this->validate($request, [
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ]);
            $user = User::find($user_id);
            $user->password = bcrypt($request->new_password);
            $user->save();
            flash()->overlay('Berhasil Mengganti password', 'INFO');
            return redirect()->route('admin.users_show', $user->id);
        }
        flash()->overlay('Kode akses yang Anda masukan salah', 'INFO');
        return redirect()->back();
    }
    public function updateTravel(Request $request, $travel_id)
    {
        $code = $request->CaptchaCode;
        $isHuman = captcha_validate($code);
        if ($isHuman) {
            $this->validate($request, [
                'travel_id' => 'required|exists:travel_agents,id',
                'name' => 'required',
                'email' => 'required|email',
                'detail' => 'required',
                'subdistrict_id' => 'required',
                'phone' => 'required',
            ]);
            //return $request->all();
            $travel = TravelAgent::find($travel_id);
            $travel->name = $request->name;
            $travel->email = $request->email;
            $travel->save();
            $travel->address->detail = $request->detail;
            $travel->address->subdistrict_id = $request->subdistrict_id;
            $travel->address->phone = $request->phone;
            $travel->address->save();

            flash()->overlay('Berhasil Memperbaharui profil travel', 'INFO');
            return redirect()->route('admin.users_show', $travel->user->id);
        }
        flash()->overlay('Kode akses yang Anda masukan salah', 'INFO');
        return redirect()->back();
    }
    public function shareLocation(Request $request, $user_id)
    {
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
        flash()->overlay('Berhasil Memperbaharui Konfigurasi Location Member', 'INFO');
        return redirect()->back();
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
            $user = $device->user;
            if ($client) {
                $client->delete();
            }
            $device->delete();
            $user->logs()->save(new UserLog(['log' => 'Berhasil reset device. Device : ' . $device->device_type . ' , Device id : ' . $device_id]));
        } catch (\Exception $e) {
            flash()->overlay('Terjadi kesalahan. Error : ' . $e->getMessage(), 'INFO');
            DB::rollback();
            return redirect()->route('admin.users_show', $user->id);
        }
        DB::commit();
        flash()->overlay('Reset device berhasil', 'INFO');
        return redirect()->route('admin.users_show', $user->id);
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
                return redirect()->route('admin.users_show', $travel->user->id);
            }
            if ($travel->url_logo != '') {
                $explode = explode('/', $travel->url_logo);
                $this->delete($explode[5]);
            }
            $travel->url_logo = $this->generateURL($allowedFileName);
            $travel->save();
            flash()->overlay('Berhasil Memperbaharui logo travel', 'INFO');
            return redirect()->route('admin.users_show', $travel->user->id);
        }
        flash()->overlay('Tidak ada logo file yang Anda pilih', 'INFO');
        return redirect()->back();
    }
    public function userLock($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->actived = 0;
            $user->save();
            flash()->overlay('Berhasil lock member', 'INFO');
            return redirect()->route('admin.users_index');
        }
        flash()->overlay('Terjadi kesalahan. Member tidak ditemukan.', 'INFO');
        return redirect()->back();
    }
    public function userUnlock($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->actived = 1;
            $user->suspended = 0;
            $user->save();
            flash()->overlay('Berhasil unlock member', 'INFO');
            return redirect()->route('admin.users_index');
        }
        flash()->overlay('Terjadi kesalahan. Member tidak ditemukan.', 'INFO');
        return redirect()->back();
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
    public function delete($fileName)
    {
        $logo = Config::get('sip-config.logo_dir');
        $full_path = $logo . $fileName;
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
    public function generateURL($filename)
    {
        $url = URL::to('/') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'logo'
            . DIRECTORY_SEPARATOR . 'travel' . DIRECTORY_SEPARATOR . $filename;
        return $url;
    }
}
