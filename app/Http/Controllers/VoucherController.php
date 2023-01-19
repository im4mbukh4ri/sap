<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use JavaScript;
use App\PpobService;
use App\Helpers\SipPpob;
use App\PointMax;
use App\PointValue;
use App\Helpers\Point\Point;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class VoucherController extends Controller
{
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
      'url' => route('voucher.transaction'),
    ]);
    $services = PpobService::where('parent_id', '18')->get();
    return view('vouchers.index', compact('services'));
  }

  public function inquery(Request $request) {
		$this->validate($request, [
			'serviceId' => 'required',
			'nominalCode' => 'required',
			'number' => 'required',
		]);
		$product = getService($request->serviceId);
    $productCode = PpobService::find($request->nominalCode)->code;
		$param = [
			'rqid' => $this->rqid,
			'app' => $this->app,
			'action' => $this->action,
			'mmid' => $this->mmid,
			'product' => $product,
			'product_code' => $productCode,
		];
		if ($request->serviceId == 1 ) {
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
    Log::info($request->all());
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
				'service_id' => 18,
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
      Log::info($param);
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
}
