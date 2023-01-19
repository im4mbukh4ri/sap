<?php

namespace App\Http\Controllers;

use App\Helpers\SipPpob;
use App\PpobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use JavaScript;
use DB;

class PulsaController extends Controller
{
    //
    private $rqid;
    private $action;
    private $app;
    private $mmid;
    private $serviceId;
    private $transaction;
    private $pulsaCommission;

    public function __construct()
    {
        $this->middleware(['auth', 'active:1', 'csrf', 'suspend:0']);
        $this->rqid = config('sip-config')['rqid'];
        $this->mmid = config('sip-config')['mmid'];
        $this->action = 'inq_ppob';
        $this->app = config('sip-config')['app']['information'];
        $this->serviceId = 1;
        $this->pulsaCommission = config('sip-config')['pulsa_commission'];
    }

    public function index(Request $request)
    {
        JavaScript::put([
            'request' => $request->all(),
            'com' => $this->pulsaCommission,
//			'url' => route('pulsa.new_transaction'),
            'url' => '',
            'urlLogo' => asset('/images/logo/operator/'),
        ]);
        return view('pulsa.index-new');
    }

    public function newInquery(Request $request)
    {
        return [
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => 'Please update your apps',
            ],
            'details' => [
                'error_code' => '001',
                'error_msg' => 'Please update your apps'
            ],
        ];
        $productService = getService($this->serviceId);
        $product = PpobService::find($request->code);

        // mode dev
        if ($request->user()->username == 'trialdev' || $request->user()->username == 'member_free') {
            $this->mmid = 'retross_01';
        }
        // end
        $param = [
            'rqid' => $this->rqid,
            'app' => $this->app,
            'action' => $this->action,
            'mmid' => $this->mmid,
            'product' => $productService,
            'product_code' => $product->code,
            'nohp' => $request->number,
        ];
        $attributes = json_encode($param);
        $status = SipPpob::inquery($attributes)->get();
        if ($status['error_code'] == '000') {
            $response['logo'] = logoOperator($product->parent_id);
            $response['name'] = $product->name;
            $response['nra'] = $product->pulsa_commission->first()->commission;
            if ($request->user()->role != 'free') {
                $response['markup'] = 0;
                $response['bv_markup'] = $product->pulsa_bv_markup->first()->markup;
                $response['price'] = $product->pulsa_price->first()->price;
                $percentPusat = $request->user()->type_user->pusat_ppob->commission;
                $percentBv = $request->user()->type_user->bv_ppob->commission;
                $percentMember = $request->user()->type_user->member_ppob->commission;
                $sip = ($response['nra'] * $percentPusat) / 100;
                $bv = (($response['nra'] * $percentBv) / 100) + $response['bv_markup'];
                $response['commission'] = ((int)$response['nra'] * $percentMember) / 100;
                $upline = 0;
            } else {
                $response['markup'] = $product->pulsa_markup->first()->markup;
                $response['bv_markup'] = $product->pulsa_bv_markup->first()->markup;
                $response['price'] = $product->pulsa_price->first()->price + $response['markup'];
                $percentPusat = $request->user()->parent->type_user->pusat_ppob->commission;
                $percentBv = $request->user()->parent->type_user->bv_ppob->commission;
                $percentMember = $request->user()->parent->type_user->member_ppob->commission;
                $sip = (($response['nra'] * $percentPusat) / 100) + $response['markup'];
                $bv = (($response['nra'] * $percentBv) / 100) + $response['bv_markup'];
                $scMember = ((int)$response['nra'] * $percentMember) / 100;
                $response['commission'] = $scMember * $request->user()->type_user->member_ppob->commission / 100;
                $feeSIP = $scMember * $request->user()->type_user->pusat_ppob->commission / 100;
                $upline = $scMember - $response['commission'] - $feeSIP;
                $sip = $sip + $feeSIP;
            }
            $response['logo'] = logoOperator($product->parent_id);
            $cookie = [
                'nra' => (int)$response['nra'],
                'commission' => $response['commission'],
                'price' => (int)$response['price'],
                'markup' => (int)$response['markup'],
                'bv_markup' => (int)$response['bv_markup'],
                'upline' => $upline,
                'pusat' => $sip,
                'bv' => $bv,
            ];
            Cookie::queue(trim($request->number) . 'Cookie' . $request->code, $cookie);
            return [
                'status' => [
                    'code' => 200,
                    'confirm' => 'success',
                    'message' => 'Success inquery ' . $product->name,
                ],
                'details' => $response,
            ];
        }
        return [
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => 'Failed inquery ' . $product->name,
            ],
            'details' => $status,
        ];
    }

    public function newTransaction(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'number' => 'required|numeric',
            'code' => 'required',
        ]);
        if ($request->cookie($request->number . 'Cookie' . $request->code) != null) {
            $credentials = ['username' => $request->user()->username, 'password' => $request->password];
            $userLogin = Auth::once($credentials);
            if ($userLogin) {
                $user = $request->user();
                $markup = $request->cookie($request->number . 'Cookie' . $request->code)['markup'];
                $price = $request->cookie($request->number . 'Cookie' . $request->code)['price'] + $request->cookie($request->number . 'Cookie' . $request->code)['markup'] - $request->cookie($request->number . 'Cookie' . $request->code)['commission'];
                $paxpaid = $request->cookie($request->number . 'Cookie' . $request->code)['price'] + $request->cookie($request->number . 'Cookie' . $request->code)['markup'];
                // if ($request->user()->username == 'ADVANCEUSER') {
                // 	$limit = LimitPaxpaid::GlobalPaxpaid((int) $paxpaid, $request->user()->id)->get();
                // 	if ($limit) {
                // 		return Response::json([
                // 			'status' => [
                // 				'code' => 400,
                // 				'confirm' => 'failed',
                // 				'message' => array('Oops! Anda melebihi limit transaksi bulan ini.'),
                // 			],
                // 		]);
                // 	}
                // }
                //
                // if ($request->user()->id == '3738' || $request->user()->id == '43794') {
                // 	Log::info('Transaksi berbarengan : ' . $request->number);
                // 	return Response::json([
                // 		'status' => [
                // 			'code' => 400,
                // 			'confirm' => 'failed',
                // 			'message' => array('Silahkan ulang kembali transaksi Anda.'),
                // 		],
                // 	]);
                // }
                $param = [
                    'service_id' => 1,
                    'code' => $request->code,
                    'price' => $price,
                    'markup' => $markup,
                    'number' => $request->number,
                    'paxpaid' => $paxpaid,
                    'device' => 'web',
                    'nra' => $request->cookie($request->number . 'Cookie' . $request->code)['nra'],
                    'pusat' => $request->cookie($request->number . 'Cookie' . $request->code)['pusat'],
                    'bv' => $request->cookie($request->number . 'Cookie' . $request->code)['bv'],
                    'bv_markup' => $request->cookie($request->number . 'Cookie' . $request->code)['bv_markup'],
                    'commission' => $request->cookie($request->number . 'Cookie' . $request->code)['commission'],
                    'upline' => $request->cookie($request->number . 'Cookie' . $request->code)['upline'],
                    'free' => 0,
                    'pr' => 0,
                ];
                $response = SipPpob::createTransaction($user->id, json_encode($param))->get();
                return Response::json($response);
            }
            return Response::json([
                'status' => [
                    'code' => 400,
                    'confirm' => 'failed',
                    'message' => array('Username atau password tidak sesuai.'),
                ],
            ]);
        }
        return Response::json([
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => array('Terjadi kesalahan pada browser Anda.'),
            ],
        ]);
    }

    public function inquery(Request $request)
    {
        $product = getService($this->serviceId);
        $productCode = PpobService::find($request->code);
        $param = [
            'rqid' => $this->rqid,
            'app' => $this->app,
            'action' => $this->action,
            'mmid' => $this->mmid,
            'product' => $product,
            'product_code' => $productCode->code,
            'nohp' => $request->number,
        ];
        $attributes = json_encode($param);
        $response = SipPpob::inquery($attributes)->get();
        if ($request->user()->role != 'free') {
            $nra = config('sip-config')['pulsa_markup'];
            //$nra = $productCode->pulsa_commission->first()->commission;
            $member = ((int)$nra * (int)$request->user()->type_user->member_ppob->commission) / 100;
            $response['commission'] = abs($member);
        } else {
            $response['total'] = $response['total'] + config('sip-config')['pulsa_markup'];
            $response['commission'] = 0;
        }
        $response['logo'] = logoOperator($productCode->parent_id);
        return $response;
    }

    public function transaction(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
            'number' => 'required|numeric',
            'code' => 'required',
        ]);
        $credentials = ['username' => $request->user()->username, 'password' => $request->password];
        $userLogin = Auth::once($credentials);
        if ($userLogin) {
            $user = $request->user();
            if ($user->role != 'free') {
                $nra = config('sip-config')['pulsa_commission'];
                $komisi = abs($nra);
                $member = ((int)$komisi * (int)$user->type_user->member_ppob->commission) / 100;
                // Sebelumnya seperti di bawah
                $price = (int)$request->price - (int)$member;
                //$price=$request->price;
            } else {
                $price = $request->price;
            }
            $paxpaid = $request->price;
            $param = [
                'service_id' => 1,
                'code' => $request->code,
                'price' => $price,
                'number' => $request->number,
                'paxpaid' => $paxpaid,
                'device' => 'web',
            ];
            $response = SipPpob::createTransaction($user->id, json_encode($param))->get();
            return Response::json($response);
        }
        return Response::json([
            'status' => [
                'code' => 400,
                'confirm' => 'failed',
                'message' => array('Username atau password tidak sesuai.'),
            ],
        ], 200);
    }

    public function reports(Request $request)
    {
        $from = date("Y-m-d", time());
        $until = date("Y-m-d", time());
        $statusReq = $request->status;
        if ($request->has('from') && $request->has('until')) {
            $from = date('Y-m-d', strtotime($request->from));
            $until = date('Y-m-d', strtotime($request->until));
            $transactions = $request->user()->ppob_transactions()->where('service', 1)->where('status', 'LIKE', '%' . $statusReq . '%')->where('status', '<>', 'failed')
                ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
            $request->flash();
        } else {
            $transactions = $request->user()->ppob_transactions()->where('service', 1)
                ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->where('status', '<>', 'failed')->get()->sortByDesc('created_at');
        }
        $totalAmount = DB::select("SELECT SUM(ppob_transactions.paxpaid) as total_marketprice, SUM(ppob_commissions.bv) as total_smartpoint, SUM(ppob_commissions.member) as total_smarcash FROM ppob_transactions
					INNER JOIN ppob_commissions ON ppob_transactions.id = ppob_commissions.ppob_transaction_id
					WHERE ppob_transactions.created_at BETWEEN '{$from} 00:00:00' AND '{$until} 23:59:59' AND ppob_transactions.user_id = '{$request->user()->id}' AND ppob_transactions.status <> 'FAILED' AND ppob_transactions.status LIKE '%{$statusReq}%' AND ppob_transactions.service ='1'");
        $from = date('d-m-Y', strtotime($from));
        $until = date('d-m-Y', strtotime($until));
        JavaScript::put([
            'request' => [
                'from' => $from,
                'until' => $until,
            ],
        ]);
        return view('pulsa.reports.index', compact('transactions', 'request', 'totalAmount'));
    }
}
