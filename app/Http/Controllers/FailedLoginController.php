<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
use App\Helpers\SipSms;
use App\Jobs\UpdatePhoneNumber;

class FailedLoginController extends Controller
{
    //
    public function __construct(){
      $this->middleware('auth');
    }

    public function resetPassword(Request $request){
        // Auth::logout();
        // $request->session()->flush();
        // Cookie::forget('laravel_session');
        return view('pages.please-reset-password');
    }
    public function dataVerification(){
        return view('pages.data-verification');
    }

    public function requestOtp(Request $request){
        $this->validate($request,[
            'no_telepon' => 'required|numeric|unique:users,phone_number',
        ]);
        $phoneNumberStr = $request->no_telepon;
        $emailStr = auth()->user()->email;
        // CHECK OBJ
        $checkDataObj = \App\RequestDataVerification::where('user_id', '=', auth()->user()->id)
            ->where('phone', '=', $phoneNumberStr)->where('email', '=', $emailStr)
            ->where('confirmed', '=', 0)->where('status', '=', 1)->orderBy('id', 'desc')->first();
        if($checkDataObj){
            $expiredInt = strtotime($checkDataObj->created_at);
            $nowInt = time();
            $calculationTimeInt = $nowInt - $expiredInt;
            if($calculationTimeInt < 420) {
                return view('pages.data-verification-otp',compact('phoneNumberStr', 'emailStr'));
            }
            $checkDataObj->status = 3;
            $checkDataObj->save();
        }

        // CREATE OBJ
        DB::beginTransaction();
        try{
            $checkDataObjArr = \App\RequestDataVerification::where('user_id', '=',auth()->user()->id)
                ->where('confirmed', '=', 0)->where('status', '=', 1)->get();
            foreach($checkDataObjArr as $checkDataObj) {
                $checkDataObj->status = 3;
                $checkDataObj->save();
            }
            $otp = $this->getOtpId(auth()->user()->id);
            $requestData = new \App\RequestDataVerification;
            $requestData->user_id = auth()->user()->id;
            $requestData->email = $emailStr;
            $requestData->phone = $phoneNumberStr;
            $requestData->otp = $otp;
            $requestData->hit = 30;
            $requestData->expired = date("Y-m-d H:i:s", time() + 420);
            $requestData->save();

            $param = [
                'rqid' => 'Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT',
                'mmid' => 'mastersip',
                'app' => 'transaction',
                'action' => 'send_sms',
                'nohp' => trim($requestData->phone),
                'pesan' => 'OTP verifikasi '.$requestData->otp.'. Berlaku sampai ' . date('Y-m-d H:i', strtotime($requestData->expired)) . ' WIB.  Pastikan Anda TIDAK MEMBERIKAN kode OTP kepada siapapun (termasuk pihak Smart In Pays).',
            ];
            $param = json_encode($param);
            $sms = SipSms::send($param)->get();
            if ($sms['error_code'] == '000') {
                $requestData->status = 1;
                $requestData->save();
            }else{
                $requestData->status = 4;
                $requestData->save();
            }

        } catch (\Exception $eObj) {
            DB::rollback();
            return redirect()->back()->withErrors('Terjadi masalah jaringan. Silahkan ulangi kembali');
        }
        DB::commit();
        return view('pages.data-verification-otp',compact('phoneNumberStr', 'emailStr'));
    }

    public function storeDataVerification(Request $request){
        $this->validate($request,[
            'otp' => 'required|numeric',
        ]);
        $userData = \App\User::find(auth()->user()->id);
        $dataValidationObj = \App\RequestDataVerification::where('user_id', '=', $userData->id)->where('confirmed', '=', 0)
            ->where('status', '=', 1)->orderBy('id', 'desc')->first();
        if(!$dataValidationObj){
            return redirect(route('data_verification'));
        }
        $dataValidationObj->hit -=1;
        $dataValidationObj->save();
        if($dataValidationObj->otp != $request->otp) {
            \App\UserLog::create([
                'user_id' => $userData->id,
                'log' => 'Failed OTP. OTP request : '.$request->otp.'. Hit :'.$dataValidationObj->hit
            ]);
            if($dataValidationObj->hit == 0) {
                $dataValidationObj->status = 3;
                $dataValidationObj->save();
                $userData->actived = 0;
                $userData->save();
                \App\UserLog::create([
                    'user_id' => $userData->id,
                    'log' => 'ID banned !'
                ]);
                Auth::logout();
                flash()->overlay('ID Anda masuk dalam block list karena melakukan percobaan kode OTP tidak wajar.', 'INFO');
                return redirect(route('index'));
            }
            return redirect()->back()->withInput(['otp'=>$request->otp])->with('error','OTP salah. Silahkan ulangi kembali.');
        }

        $expiredInt = strtotime($dataValidationObj->created_at);
        $nowInt = time();
        $calculationTimeInt = $nowInt - $expiredInt;
        if($calculationTimeInt > 420) {
            \App\UserLog::create([
                'user_id' => $userData->id,
                'Log' => 'Failed OTP. OTP request : '.$request->otp. 'Note : OTP is expired'
            ]);
            return redirect(route('data_verification'))->with('error', 'OTP sudah melewati batas waktu ( 5 Menit ). Silahkan ulangi kembali.');
        }
        DB::beginTransaction();
        try{
            $userData->email = $dataValidationObj->email;
            $userData->phone_number = $dataValidationObj->phone;
            $userData->suspended = 0;
            $userData->save();
            $dataValidationObj->confirmed = 1;
            $dataValidationObj->save();
            \App\UserLog::create([
                'user_id' => $userData->id,
                'log' => 'Success verification. OTP request : '.$request->otp
            ]);
        } catch (\Exception $eObj){
            DB::rollback();
            return redirect(route('data_verification'))->with('error','Terjadi masalah jaringan. Silahkan ulangi kembali.');
        }
        DB::commit();
        $this->dispatch(new UpdatePhoneNumber($userData->username, $userData->phone_number));
        return redirect(route('index'));
    }

    private function getOtpId($userId) {
        $i = 1;
        $otpId = null;
        $date = date('Y-m-d', time());
        while (true) {
            $otpId = $i . substr("" . time(), -5);
            if (\App\RequestDataVerification::where('user_id', $userId)->where('otp', '=', $otpId)->first() === null) {
                break;
            }
            $i++;
        }
        return $otpId;
    }
}
