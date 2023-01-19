<?php

namespace App\Http\Controllers;

use App\Helpers\LimitPaxpaid;
use App\Helpers\Point\Point;
use App\Helpers\SipPpob;
use App\PointMax;
use App\PointValue;
use App\PpobService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use JavaScript;

class PpobController extends Controller {
	protected $rqid;
	protected $mmid;
	protected $action;
	protected $app;
	public function __construct() {
		$this->middleware(['auth', 'active:1', 'csrf', 'suspend:0']);
		$this->rqid = config('sip-config')['rqid'];
		$this->mmid = config('sip-config')['mmid'];
		$this->action = "inq_ppob";
		$this->app = "information";
	}

	public function index(Request $request) {
		JavaScript::put([
			'request' => $request->all(),
			'url' => route('ppob.transaction'),
		]);
		$services = PpobService::where('parent_id', '0')->get();
		return view('ppob.index', compact('services'));
	}

	public function inquery(Request $request) {
		$this->validate($request, [
			'serviceId' => 'required',
			'nominalCode' => 'required',
			'number' => 'required',
		]);
		$product = getService($request->serviceId);
		switch ($request->serviceId) {
		case 2:
			$productCode = PpobService::find($request->serviceId)->code;
			break;
		case 3:
			$productCode = PpobService::find($request->serviceId)->code;
			break;
		default:
			$productCode = PpobService::find($request->nominalCode)->code;
			break;
		}
		$param = [
			'rqid' => $this->rqid,
			'app' => $this->app,
			'action' => $this->action,
			'mmid' => $this->mmid,
			'product' => $product,
			'product_code' => $productCode,
		];
		if ($request->serviceId == 1 || $request->serviceId == 18) {
			$param['nohp'] = $request->number;
		} else {
			$param['noid'] = $request->number;
		}
		$attributes = json_encode($param);
		$response = SipPpob::inquery($attributes)->get();
		if ($request->user()->role != 'free') {
			$commission = 0;
			if (isset($response['nra'])) {
				$nra = $response['nra'];
				$komisi = ((int) $nra * (int) config('sip-config')['member_commission']) / 100;
				$member = ((int) $komisi * (int) $request->user()->type_user->member_ppob->commission) / 100;
				/*
					                 * Sebelum di ganti seperti di bawah ini
					                 * $free = (int)$nra-(int)$komisi;
					                 * $commission=(int)$free+$member;
				*/
				$commission = (int) $member;
			}
		} else {
			$commission = 0;
		}
		$response['commission'] = $commission;
		$response['max_point'] = PointMax::find(1)->point;
		$response['user_point'] = $request->user()->point;

		if ($response['error_code'] == '000') {
			if ($request->serviceId != 2) {
				Cookie::queue(trim($request->number) . 'Com', $response['commission']);
				Cookie::queue(trim($request->number) . 'Adm', (int) $response['admin']);
				Cookie::queue(trim($request->number) . 'Prc', (int) $response['total']);
			} else {
				Cookie::queue(trim($request->number) . 'Com', $response['commission']);
				Cookie::queue(trim($request->number) . 'Adm', (int) $response['admin']);
				Cookie::queue(trim($request->number) . 'Prc', 1);
			}
		}
		return Response::json($response);
	}

	public function transaction(Request $request) {
		$this->validate($request, [
			'password' => 'required',
			'number' => 'required',
			'code' => 'required',
			'service_id' => 'required',
		]);
		$prValue = PointValue::find(1)->idr;
		$user = $request->user();
		Log::info("Point : " . $request->pr);
		if ((int) $request->pr > 3) {
			return Response::json([
				'status' => [
					'code' => 400,
					'confirm' => 'failed',
					'message' => array('Proses gagal.'),
				],
			]);
		}
		$point = Point::check($user->id, (int) $request->pr)->get();
		if (!$point) {
			return Response::json([
				'status' => [
					'code' => 400,
					'confirm' => 'failed',
					'message' => array('Proses gagal. Periksa kembali point Anda / Refresh halaman ini. Terimakasih.'),
				],
			]);
		}
		if ($request->cookie($request->number . 'Com') != null && $request->cookie($request->number . 'Adm') != null && $request->cookie($request->number . 'Prc') != null) {
//            Log::info([$request->cookie($request->number.'Com'),gettype($request->cookie($request->number.'Com'))]);
			//            Log::info([$request->cookie($request->number.'Adm'),gettype($request->cookie($request->number.'Adm'))]);
			//            Log::info([$request->cookie($request->number.'Prc'),gettype($request->cookie($request->number.'Prc'))]);
		} else {
			return Response::json([
				'status' => [
					'code' => 400,
					'confirm' => 'failed',
					'message' => array('Terjadi kesalahan pada browser Anda.'),
				],
			]);
		}
		$credentials = ['username' => $request->user()->username, 'password' => $request->password];
		$userLogin = Auth::once($credentials);
		if ($userLogin) {
			$param = [
				'service_id' => $request->service_id,
				'code' => $request->code,
				'number' => $request->number,
			];
			$pr = (int) $request->pr * $prValue;
			$param['pr'] = $pr;
			if ((int) $request->pr > 0) {
				$param['point'] = $request->pr;
			}
			switch ($request->service_id) {
			case '2':
				$product = PpobService::find($request->code);
				$strNominal = substr($product->code, 3);
				$strNominal = $strNominal . "000";
//                    if($request->cookie($request->number.'Com')!=null&&$request->cookie($request->number.'Adm')){
				//                        $paxpaid=(int)$strNominal+(int)$request->cookie($request->number.'Adm');
				//                        $param['price']=$paxpaid-$request->cookie($request->number.'Com');
				//                    }else{
				//                        $paxpaid=(int)$strNominal+(int)$request->admin;
				//                        $param['price']=$paxpaid-$request->commission;
				//                    }
				$paxpaid = (int) $strNominal + (int) $request->cookie(trim($request->number) . 'Adm');
				$param['price'] = $paxpaid - $request->cookie(trim($request->number) . 'Com') - (int) $param['pr'];
				$param['paxpaid'] = $paxpaid;
				break;
			case '3':
//                    if($request->cookie($request->number.'Com')!=null&&$request->cookie($request->number.'Adm')){
				//                        $param['price']=(int)$request->cookie($request->number.'Prc')-(int)$request->cookie($request->number.'Com');
				//                    }else{
				//                        $param['price']=(int)$request->price-(int)$request->commission;
				//                    }
				$param['price'] = (int) $request->cookie(trim($request->number) . 'Prc') - (int) $request->cookie(trim($request->number) . 'Com') - (int) $param['pr'];
				$param['paxpaid'] = (int) $request->cookie(trim($request->number) . 'Prc');
				break;
			case '9':
//                    if($request->cookie($request->number.'Com')!=null&&$request->cookie($request->number.'Adm')){
				//                        $param['price']=(int)$request->cookie($request->number.'Prc')-(int)$request->cookie($request->number.'Com');
				//                    }else{
				//                        $param['price']=(int)$request->price-(int)$request->commission;
				//                    }
				$param['paxpaid'] = (int) $request->cookie(trim($request->number) . 'Prc');
				$param['price'] = (int) $request->cookie(trim($request->number) . 'Prc') - (int) $request->cookie(trim($request->number) . 'Com') - (int) $param['pr'];
				break;
			case '348':
				$param['nominal'] = $request->nominal;
				$param['paxpaid'] = $request->nominal + (int) $request->cookie(trim($request->number) . 'Adm');
				$param['price'] = $request->nominal + $request->cookie(trim($request->number) . 'Adm') - (int) $request->cookie(trim($request->number) . 'Com') - (int) $param['pr'];
				$param['reff'] = '';
				break;
			default:
//                    if($request->cookie($request->number.'Com')!=null&&$request->cookie($request->number.'Adm')){
				//                        $param['price']=(int)$request->cookie($request->number.'Prc')-(int)$request->cookie($request->number.'Com');
				//                    }else{
				//                        $param['price']=(int)$request->price-(int)$request->commission;
				//                    }
				$param['paxpaid'] = (int) $request->cookie(trim($request->number) . 'Prc');
				$param['price'] = (int) $request->cookie(trim($request->number) . 'Prc') - (int) $request->cookie(trim($request->number) . 'Com') - (int) $param['pr'];
				$param['reff'] = $request->reff;
				break;
			}
			Cookie::queue(Cookie::forget(trim($request->number) . 'Prc'));
			Cookie::queue(Cookie::forget(trim($request->number) . 'Com'));
			Cookie::queue(Cookie::forget(trim($request->number) . 'Adm'));
			$param['device'] = 'web';
			if ($request->user()->username == "ADVANCEUSER") {
				$limit = LimitPaxpaid::GlobalPaxpaid((int) $param['paxpaid'], $request->user()->id)->get();
				if ($limit) {
					return Response::json([
						'status' => [
							'code' => 400,
							'confirm' => 'failed',
							'message' => array('Oops! Anda melebihi limit transaksi bulan ini.'),
						],
					]);
				}
			}
			$response = SipPpob::createTransaction($user->id, json_encode($param))->get();
			if ($request->save_number == "true") {
				if (count($user->number_saveds()->where('service', $request->service_id)->get()) < 10) {
					$user->number_saveds()->create([
						'id' => $this->getNumberId(),
						'service' => $request->service_id,
						'ppob_service_id' => $request->code,
						'name' => $request->name,
						'number' => $request->number,
					]);
				}
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

	public function reports(Request $request) {
		$from = date("Y-m-d", time());
		$until = date("Y-m-d", time());
		$statusReq = $request->status;
		$reqService = $request->service;
		if ($request->has('from') && $request->has('until')) {
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$transactions = $request->user()->ppob_transactions()->where('service', '<>', 1)->where('status', 'LIKE', '%' . $statusReq . '%')->where('service', 'LIKE', '%' . $reqService . '%')->where('status', '<>', 'failed')
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
			$request->flash();
		} else {
			$transactions = $request->user()->ppob_transactions()->where('service', '<>', 1)->where('status', '<>', 'failed')
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
		}
		$totalAmount = DB::select("SELECT SUM(ppob_transactions.paxpaid) as total_marketprice, SUM(ppob_commissions.bv) as total_smartpoint, SUM(ppob_commissions.member) as total_smarcash FROM ppob_transactions
    					INNER JOIN ppob_commissions ON ppob_transactions.id = ppob_commissions.ppob_transaction_id
    					WHERE ppob_transactions.created_at BETWEEN '{$from} 00:00:00' AND '{$until} 23:59:59' AND ppob_transactions.user_id = '{$request->user()->id}' AND ppob_transactions.status <> 'failed' AND ppob_transactions.status LIKE '%{$statusReq}%' AND ppob_transactions.service <> '1' AND ppob_transactions.service LIKE '%{$reqService}%'");
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		return view('ppob.reports.index', compact('transactions', 'request', 'totalAmount'));
	}

	public function newReports(Request $request) {
		$from = date("Y-m-d", time());
		$until = date("Y-m-d", time());
		if ($request->has('from') && $request->has('until')) {
			$from = date('Y-m-d', strtotime($request->from));
			$until = date('Y-m-d', strtotime($request->until));
			$transactions = $request->user()->ppob_transactions()->where('service', '<>', 1)
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
			$request->flash();
		} else {
			$transactions = $request->user()->ppob_transactions()->where('service', '<>', 1)
				->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get()->sortByDesc('created_at');
		}
		$from = date('d-m-Y', strtotime($from));
		$until = date('d-m-Y', strtotime($until));
		JavaScript::put([
			'request' => [
				'from' => $from,
				'until' => $until,
			],
		]);
		return view('ppob.reports.new-index', compact('transactions', 'request'));
	}
	private function getNumberId() {
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
