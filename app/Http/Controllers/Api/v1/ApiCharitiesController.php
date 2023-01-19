<?php
namespace app\Http\Controllers\Api\v1;

use App\Charity;
use App\CharityTransaction;
use App\Helpers\Deposit\Deposit;
use App\Helpers\SipCharity;
use App\Http\Controllers\Controller;
use App\OauthClientSecret;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Response;

class ApiCharitiesController extends Controller {
	private $confirmSuccess = 'success';
	private $confirmFailed = 'failed';
	private $codeSuccess = 200;
	private $codeFailed = 400;
	private $statusMessage;

	public function lists() {
		$charities = Charity::where('status', '=', 1)->get();
		$this->setStatusMessage("Berhasil mendapatkan list charities.");
		if (count($charities) === 0) {
			$this->setStatusMessage("Belum ada program charity yang sedang berjalan.");
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		return Response::json([
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => $charities,
		]);
	}
	public function transferCharity(Request $request) {
		$validator = Validator::make($request->all(), [
			'charity_id' => 'required|exists:charities,id',
			'nominal' => 'required|numeric'
		]);
		if ($validator->fails()) {
			$this->setStatusMessage($validator->errors());
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		if((int)$request->nominal < 10000){
            $this->setStatusMessage('Minimal transfer charity adalah IDR 10.000');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ], 400);
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
			], 400);
		}
//		$credentials = ['username' => $client->user->username, 'password' => $request->password];
//		$userLogin = Auth::once($credentials);
        $userLogin = true;
		if ($userLogin) {
			$nominal = (int) $request->nominal;
			$minCharity = 5000;
			if ((int) $nominal % $minCharity != 0) {
				$this->setStatusMessage('Minimal transfer charity adalah IDR 10.000 dan kelipatan IDR ' . number_format($minCharity));
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				], 400);
			}
			if (!Deposit::check($client->user->id, $nominal)) {
				$this->setStatusMessage('Saldo Anda tidak cukup untuk melakukan transfer charity.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				], 400);
			}
			$transferCharity = SipCharity::TransferCharity($client->user->id, $request->charity_id, $nominal);
			if ($transferCharity['status']['code'] == 200) {
				$this->setStatusMessage('Transfer berhasil. Terimakasih telah mengikuti program charity kami.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeSuccess(),
						'confirm' => $this->getConfirmSuccess(),
						'message' => $this->getStatusMessage(),
					],
				], 200);
			}
			$this->setStatusMessage('Gagal transfer charity.');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			], 400);
		}
		$this->setStatusMessage('Password Salah.');
		return Response::json([
			'status' => [
				'code' => $this->getCodeFailed(),
				'confirm' => $this->getConfirmFailed(),
				'message' => $this->getStatusMessage(),
			],
		], 400);
	}

	public function report(Request $request) {
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
				$this->setStatusMessage('History deposit yang bisa Anda cek maksimal 31 hari.');
				return Response::json([
					'status' => [
						'code' => $this->getCodeFailed(),
						'confirm' => $this->getConfirmFailed(),
						'message' => $this->getStatusMessage(),
					],
				]);
			}
			$this->setStatusMessage('Success get charity histories');
			$charities = CharityTransaction::whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->where('user_id', '=', $user->id)->get();
		} else {
			$this->setStatusMessage('periksa tanggal awal dan tanggal akhir (start_date & end_date');
			return Response::json([
				'status' => [
					'code' => $this->getCodeFailed(),
					'confirm' => $this->getConfirmFailed(),
					'message' => $this->getStatusMessage(),
				],
			]);
		}
		return Response::json([
			'status' => [
				'code' => $this->getCodeSuccess(),
				'confirm' => $this->getConfirmSuccess(),
				'message' => $this->getStatusMessage(),
			],
			'details' => $charities,
		]);
	}

	private function getCodeSuccess() {
		return $this->codeSuccess;
	}
	private function getCodeFailed() {
		return $this->codeFailed;
	}
	private function getConfirmSuccess() {
		return $this->confirmSuccess;
	}
	private function getConfirmFailed() {
		return $this->confirmFailed;
	}
	private function setStatusMessage($message) {
		(is_array($message) ? $this->statusMessage = $message : $this->statusMessage = array($message));
	}
	private function getStatusMessage() {
		return $this->statusMessage;
	}

}