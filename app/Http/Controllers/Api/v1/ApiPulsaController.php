<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\LimitPaxpaid;
use App\Helpers\SipPpob;
use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClientSecret;
use App\PpobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiPulsaController extends Controller
{
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;
    private $rqid;
    private $mmid;
    private $app;
    private $action;

    public function __construct(Request $request)
    {
        $this->middleware('oauth');
        $this->rqid = config('sip-config')['rqid'];
        $this->mmid = config('sip-config')['mmid'];
        $this->action = 'inq_ppob';
        $this->app = config('sip-config')['app']['information'];
//		if ($request->hasHeader('authorization')) {
//			$token = explode(' ', $request->header('authorization'));
//			$newTime = time() + 259200;
//			$accessToken = OauthAccessToken::find($token[1]);
//			$accessToken->expire_time = $newTime;
//			$accessToken->save();
//		}
//		if ($request->has('access_token')) {
//			$newTime = time() + 259200;
//			$accessToken = OauthAccessToken::find($request->access_token);
//			$accessToken->expire_time = $newTime;
//			$accessToken->save();
//		}
    }

    public function operators()
    {
        $this->action = 'inq_ppob';
        $operators = PpobService::where('parent_id', 1)->get();
        $this->setStatusMessage('Berhasil mendapatkan operator');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'operators' => $operators,
            ],
        ]);
    }

    public function nominal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator_id' => 'required|exists:ppob_services,parent_id',
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return Response::json([
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $nominal = PpobService::where('parent_id', $request->operator_id)->where('status', '=', 1)->orderBy('updated_at')->get();
        $this->setStatusMessage('Berhasil mendapatkan nominal');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'nominal' => $nominal,
            ],
        ]);
    }

    public function inquery(Request $request)
    {
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => 'Please update your apps',
            ],
        ]);
        $validator = Validator::make($request->all(), [
            'nominal_id' => 'required|exists:ppob_services,code',
            'number' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $client = OauthClientSecret::where('client_id', $request->client_id)->first();
        if (!$client) {
            $this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $user = $client->user;
        if ($user->actived == 0) {
            $this->setStatusMessage('Maaf, ID anda sedang dalam block list. Silahkan hubungi cutomer service.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }

        return $this->newInquery($request, $user);
    }

    public function newInquery($request, $user)
    {
        $service = getService(1);
        $product = PpobService::where('code', $request->nominal_id)->first();
        $productCode = $request->nominal_id;
        $param = [
            'rqid' => $this->rqid,
            'app' => $this->app,
            'action' => $this->action,
            'mmid' => $this->mmid,
            'product' => $service,
            'product_code' => $productCode,
            'nohp' => $request->number,
        ];
        $attributes = json_encode($param);
        $response = SipPpob::inquery($attributes)->get();
        if ($response['error_code'] == '001') {
            $this->setStatusMessage($response['error_msg']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $response['nra'] = $product->pulsa_commission->first()->commission;
        $response['bv_markup'] = $product->pulsa_bv_markup->first()->markup;
        if ($user->role != 'free') {
            $response['markup'] = 0;
            $response['price'] = (int)$product->pulsa_price->first()->price;
            $percentPusat = $user->type_user->pusat_ppob->commission;
            $percentBv = $user->type_user->bv_ppob->commission;
            $percentMember = $user->type_user->member_ppob->commission;
            $sip = ($response['nra'] * $percentPusat) / 100;
            $bv = ($response['nra'] * $percentBv) / 100;
            $response['commission'] = floor(((int)$response['nra'] * $percentMember) / 100);
            $upline = 0;
        } else {
            $response['markup'] = $product->pulsa_markup->first()->markup;
            $response['price'] = (int)$product->pulsa_price->first()->price + $response['markup'];
            $percentPusat = $user->parent->type_user->pusat_ppob->commission;
            $percentBv = $user->parent->type_user->bv_ppob->commission;
            $percentMember = $user->parent->type_user->member_ppob->commission;
            $sip = (($response['nra'] * $percentPusat) / 100) + $response['markup'];
            $bv = ($response['nra'] * $percentBv) / 100;
            $scMember = ((int)$response['nra'] * $percentMember) / 100;
            $response['commission'] = 0;
            $upline = $scMember;
        }
        $this->setStatusMessage('Berhasil inquery');
        $myRes = [
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'inquery' => [
                    'number' => $response['nohp'],
                    'nominal_id' => $request->nominal_id,
                    'name' => $response['nama'],
                    'price' => (int)$response['price'],
                    'commission' => $response['commission'],
                    'market_price' => (int)$response['price'],
                    'smart_price' => (int)$response['price'] - $response['commission']
                ],
            ],
        ];
        return Response::json($myRes);
    }

    public function transaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|numeric',
            'nominal_id' => 'required|exists:ppob_services,code',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors()->first());
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $client = OauthClientSecret::where('client_id', $request->client_id)->first();
        if (!$client) {
            $this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $user = $client->user;
        if ($request->has('pin')) {
            $userLogin = Hash::check($request->pin, $user->pin);
        } else {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                $this->setStatusMessage($validator->errors()->first());
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
            $credentials = ['username' => $user->username, 'password' => $request->password];
            $userLogin = Auth::once($credentials);
        }

        if ($userLogin) {
            return $this->newTransaction($request, $user, $client);
        }
        return Response::json([
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => array('Password tidak sesuai.'),
            ],
        ]);
    }

    public function newTransaction($request, $user, $client)
    {

        $product = PpobService::where('code', $request->nominal_id)->first();
        $nra = $product->pulsa_commission->first()->commission;
        $paxpaid = $product->pulsa_price->first()->price;
        // if (
        // 	$user->username == "member_silver" ||
        // 	$user->username == "member_platinum" ||
        // 	$user->username == "member_gold" ||
        // 	$user->username == "member_free" ||
        // 	$user->username == "trialdev" ||
        // 	$user->username == "prouser" ||
        // 	$user->username == "advanceuser" ||
        // 	$user->username == "basicuser"

        // ) {
        // 	$limit = LimitPaxpaid::GlobalPaxpaid($paxpaid, $user->id)->get();
        // 	if ($limit) {
        // 		$this->setStatusMessage('Oops! Anda melebihi limit transaksi bulan ini.');
        // 		return Response::json([
        // 			'status' => [
        // 				'code' => $this->getCodeFailed(),
        // 				'confirm' => $this->getConfirmFailed(),
        // 				'message' => $this->getStatusMessage(),
        // 			],
        // 		], 400);
        // 	}
        // }

        $bvMarkup = $product->pulsa_bv_markup->first()->markup;
        if ($user->role != 'free') {
            $markup = 0;
            $price = (int)$product->pulsa_price->first()->price;
            $percentPusat = $user->type_user->pusat_ppob->commission;
            $percentBv = $user->type_user->bv_ppob->commission;
            $percentMember = $user->type_user->member_ppob->commission;
            $sip = ceil(($nra * $percentPusat) / 100);
            $bv = floor((($nra * $percentBv) / 100) + $bvMarkup);
            $komisi = floor(((int)$nra * $percentMember) / 100);
            $upline = 0;
            $price = (int)$price - $komisi;
        } else {
            $markup = $product->pulsa_markup->first()->markup;
            $price = (int)$product->pulsa_price->first()->price + $markup;
            $percentPusat = $user->parent->type_user->pusat_ppob->commission;
            $percentBv = $user->parent->type_user->bv_ppob->commission;
            $percentMember = $user->parent->type_user->member_ppob->commission;
            $sip = ceil((($nra * $percentPusat) / 100) + $markup);
            $bv = floor((($nra * $percentBv) / 100) + $bvMarkup);
            $scMember = floor(((int)$nra * $percentMember) / 100);
            $komisi = 0;
            $upline = $scMember;
        }
        $param = [
            'service_id' => 1,
            'code' => $product->id,
            'price' => $price,
            'number' => $request->number,
            'paxpaid' => $paxpaid,
            'markup' => $markup,
            'bv_markup' => $bvMarkup,
            'device' => $client->device_type,
            'nra' => $nra,
            'pusat' => $sip,
            'bv' => $bv,
            'commission' => $komisi,
            'upline' => $upline,
            'free' => 0,
            'pr' => 0,
        ];
        $response = SipPpob::createTransaction($user->id, json_encode($param))->get();
        return Response::json($response);
    }

    public function reports(Request $request)
    {
        $client = OauthClientSecret::where('client_id', $request->client_id)->first();
        if (!$client) {
            $this->setStatusMessage(['Anda tidak terdaftar', 'clinet_id tidak ditemukan']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $user = $client->user;
        if ($request->has('start_date') && $request->has('end_date')) {
            $from = date('Y-m-d', strtotime($request->start_date));
            $until = date('Y-m-d', strtotime($request->end_date));
            if (daysDifference($until, $from) > 31) {
                $this->setStatusMessage('Report pulsa yang bisa Anda cek maksimal 31 hari.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
            $transactions = $user->ppob_transactions()->where('service', 1)
                ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get();
            $this->setStatusMessage('Berhasil mendapatkan report');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
                'details' => $transactions,
            ]);
        }
        $this->setStatusMessage('periksa tanggal awal dan tanggal akhir (start_date & end_date');
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
    }

    private function getCodeSuccess()
    {
        return $this->codeSuccess;
    }

    private function getCodeFailed()
    {
        return $this->codeFailed;
    }

    private function getConfirmSuccess()
    {
        return $this->confirmSuccess;
    }

    private function getConfirmFailed()
    {
        return $this->confirmFailed;
    }

    private function setStatusMessage($message)
    {
        (is_array($message) ? $this->statusMessage = $message : $this->statusMessage = array($message));
    }

    private function getStatusMessage()
    {
        return $this->statusMessage;
    }
}
