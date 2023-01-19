<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\LimitPaxpaid;
use App\Helpers\SipPpob;
use App\Http\Controllers\Controller;
use App\Jobs\InquiryPpob;
use App\OauthAccessToken;
use App\OauthClientSecret;
use App\PointValue;
use App\PpobInquiry;
use App\PpobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiPpobController extends Controller
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
//        if ($request->hasHeader('authorization')) {
//            $token = explode(' ', $request->header('authorization'));
//            $newTime = time() + 259200;
//            $accessToken = OauthAccessToken::find($token[1]);
//            $accessToken->expire_time = $newTime;
//            $accessToken->save();
//        }
//        if ($request->has('access_token')) {
//            $newTime = time() + 259200;
//            $accessToken = OauthAccessToken::find($request->access_token);
//            $accessToken->expire_time = $newTime;
//            $accessToken->save();
//        }
    }

    public function services()
    {
        $services = PpobService::where('parent_id', 0)->where('id', '<>', 1)->where('status', '=', 1)->get();
        $this->setStatusMessage('Berhasil mendapatkan service');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => $services,
        ]);
    }

    public function products(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:ppob_services,id',
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
        $products = PpobService::find($request->service_id);
        if ($request->service_id != 3) {
            $products = $products->childs()->where('status', '=', 1)->get();
        } else {
            $products = array($products);
        }
        $this->setStatusMessage('Berhasil mendapatkan produk');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => $products,
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
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'product_id' => 'required|exists:ppob_services,code',
            'number' => 'required',
            'client_id' => 'required',
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
        $product = $request->service_id;
        $productCode = $request->product_id;
        if (substr($productCode, 0, 3) == "PLA") {
            $productCode = "PRA";
        }
        if ($user->username == 'trialdev') {
            $this->mmid = 'retross_01';
        }
        $param = [
            'rqid' => $this->rqid,
            'app' => $this->app,
            'action' => $this->action,
            'mmid' => $this->mmid,
            'product' => $product,
            'product_code' => $productCode,
            'noid' => $request->number,
        ];
        $attributes = json_encode($param);
        $response = SipPpob::inquery($attributes)->get();
        if ($response['error_code'] == '000') {
            if ($productCode == "PRA") {
                $strNominal = substr($request->product_id, 3);
                $strNominal = $strNominal . "000";
                $paxpaid = (int)$strNominal + (int)$response['admin'];
                $price = $paxpaid;
                $response['price'] = $price;
                if ($user->role != 'free') {
                    $commission = 0;
                    if (isset($response['nra'])) {
                        $nra = $response['nra'];
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $member = ((int)$komisi * (int)$user->type_user->member_ppob->commission) / 100;
                        $commission = (int)$member;
                    }
                } else {
                    $commission = 0;
                    if (isset($response['nra'])) {
                        $nra = $response['nra'];
                        $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                        $member = ((int)$komisi * (int)$user->parent->type_user->member_ppob->commission) / 100;
                        $free = floor(($member * $user->type_user->member_ppob->commission) / 100);
                        $commission = $free;
                    }
                }
                unset($response['saldo']);
                $response['commission'] = $commission;
                $response['market_price'] = $response['price'];
                $response['smart_price'] = $response['price'] - $response['commission'];
                try {
                    PpobInquiry::create([
                        'user_id' => $user->id,
                        'product_id' => $request->product_id,
                        'number' => $request->number,
                        'price' => $response['price'],
                        'commission' => $response['commission'],
                        'admin' => $response['admin']
                    ]);
                } catch (\Exception $e) {
                    $this->setStatusMessage('Silahkan ulangi kembali.');
                    return Response::json([
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ]);
                }
                $this->setStatusMessage('Berhasil inquery');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeSuccess(),
                        'confirm' => $this->getConfirmSuccess(),
                        'message' => $this->getStatusMessage(),
                    ],
                    'details' => [
                        'inquery' => $response,
                    ],
                ]);
            }
            $response['price'] = $response['total'];
            unset($response['total']);
            unset($response['saldo']);
            if ($user->role != 'free') {
                $commission = 0;
                if (isset($response['nra'])) {
                    $nra = $response['nra'];
                    $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                    $member = ((int)$komisi * (int)$user->type_user->member_ppob->commission) / 100;
                    $commission = $member;
                }
            } else {
                $commission = 0;
                if (isset($response['nra'])) {
                    $nra = $response['nra'];
                    $komisi = ((int)$nra * (int)config('sip-config')['member_commission']) / 100;
                    $member = ((int)$komisi * (int)$user->parent->type_user->member_ppob->commission) / 100;
                    $free = floor(($member * $user->type_user->member_ppob->commission) / 100);
                    $commission = $free;
                }
            }
            try {
                PpobInquiry::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'number' => $request->number,
                    'price' => $response['price'],
                    'commission' => $commission,
                    'admin' => $response['admin']
                ]);
            } catch (\Exception $e) {
                $this->setStatusMessage('Silahkan ulangi kembali.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
            $response['commission'] = $commission;
            $response['market_price'] = $response['price'];
            $response['smart_price'] = $response['price'] - $response['commission'];
            $this->setStatusMessage('Berhasil inquery');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
                'details' => [
                    'inquery' => $response,
                ],
            ]);
        }
        $this->setStatusMessage($response['error_msg']);
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
    }

    public function transaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required',
            'product_id' => 'required|exists:ppob_services,code',
            'number' => 'required',
            'client_id' => 'required',
//            'password' => 'required',
            'admin' => 'required',
            'commission' => 'required',
            'price' => 'required',
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
        $checkInquiry = PpobInquiry::where('user_id', '=', $user->id)
            ->where('product_id', '=', $request->product_id)->where('number', '=', $request->number)
            ->orderBy('created_at', 'desc')->first();
        if(!$checkInquiry){
            $this->setStatusMessage(['Silahkan cek tagihan terlebih dahulu.']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        if(((int) $checkInquiry->price != (int) $request->price) || ((int) $checkInquiry->commission != (int) $request->commission) || (int) $checkInquiry->admin != (int) $request->admin){
            $this->setStatusMessage(['Silahkan cek tagihan terlebih dahulu.']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $prValue = PointValue::find(1)->idr;
//        $credentials = ['username' => $user->username, 'password' => $request->password];
//        $userLogin = Auth::once($credentials);
        $userLogin = true;
        if ($userLogin) {
            if (substr($request->product_id, 0, 3) == 'PLA') {
                $request->service_id = 2;
            } elseif ($request->product_id == 'PAS') {
                $request->service_id = 3;
            } else {
                $request->service_id = PpobService::where('code', $request->service_id)->first()->id;
            }
            $request->product_id = PpobService::where('code', $request->product_id)->first()->id;
            $param = [
                'service_id' => $request->service_id,
                'code' => $request->product_id,
                'number' => $request->number,
            ];
            $param['pr'] = 0;
            if ($request->has('pr')) {
                Log::info("Point Ppob From Mobile: " . $request->pr);
                if ((int)$request->pr > 3) {
                    return Response::json([
                        'status' => [
                            'code' => 400,
                            'confirm' => 'failed',
                            'message' => array('Proses gagal.'),
                        ],
                    ]);
                }
                if ((int)$request->pr > 0) {
                    $param['pr'] = $request->pr * $prValue;
                    $param['point'] = $request->pr;
                }
            }

            switch ($request->service_id) {
                case '2':
                    $product = PpobService::find($request->product_id);
                    $strNominal = substr($product->code, 3);
                    $strNominal = $strNominal . "000";
                    $paxpaid = (int)$strNominal + (int)$request->admin;
                    $param['price'] = $paxpaid - $request->commission - $param['pr'];
                    $param['paxpaid'] = $paxpaid;
                    break;
                case '3':
                    $param['price'] = $request->price - $request->commission - $param['pr'];
                    $param['paxpaid'] = $request->price;
                    break;
                case '9':
                    $param['paxpaid'] = $request->price;
                    $param['price'] = $request->price - $request->commission - $param['pr'];
                    break;
                case '348':
                    $param['nominal'] = $request->nominal;
                    $param['paxpaid'] = $request->nominal + $request->admin;
                    $param['price'] = $request->nominal + $request->admin - $request->commission - $param['pr'];
                    $param['reff'] = $request->reff;
                    break;
                default:
                    $param['paxpaid'] = $request->price;
                    $param['price'] = $request->price - $request->commission - $param['pr'];
                    $param['reff'] = $request->reff;
                    break;
            }
            if (
                $user->username == "member_silver" ||
                $user->username == "member_platinum" ||
                $user->username == "member_gold" ||
                $user->username == "member_free" ||
                $user->username == "trialdev" ||
                $user->username == "prouser" ||
                $user->username == "advanceuser" ||
                $user->username == "basicuser"
            ) {
                $limit = LimitPaxpaid::GlobalPaxpaid((int)$param['paxpaid'], $user->id)->get();
                if ($limit) {
                    $this->setStatusMessage('Oops! Anda melebihi limit transaksi bulan ini.');
                    return Response::json([
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ], 400);
                }
            }
            $param['device'] = $client->device_type;
            $response = SipPpob::createTransaction($user->id, json_encode($param))->get();
            if ($request->has("save_num") && $request->save_num == "1" && count($user->number_saveds()->where('service', $param['service_id'])->get()) < 10) {
                $user->number_saveds()->create([
                    'id' => $this->getNumberId(),
                    'service' => $param['service_id'],
                    'ppob_service_id' => $param['code'],
                    'name' => $request->name,
                    'number' => $param['number'],
                ]);
            }
            return Response::json($response);
        }
        return Response::json([
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => array('Password tidak sesuai'),
            ],
        ], 200);
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
            $transactions = $user->ppob_transactions()->where('service', '<>', 1)
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

    private function getNumberId()
    {
        $i = 1;
        $numberId = null;
        while (true) {
            $numberId = $i . substr("" . time(), -4);
            if (\App\NumberSaved::find($numberId) === null) {
                break;
            }
            $i++;
        }
        return $numberId;
    }
}
