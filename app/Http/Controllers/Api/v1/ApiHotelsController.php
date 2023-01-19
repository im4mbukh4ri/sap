<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\Deposit\Deposit;
use App\Helpers\SipHotel;
use App\Hotel;
use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClientSecret;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiHotelsController extends Controller
{
    private $rqid;
    private $mmid;
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;

    public function __construct(Request $request)
    {
        $this->rqid = config('sip-config')['rqid'];
        $this->mmid = config('sip-config')['mmid'];
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

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'des' => 'required|exists:hotel_cities,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'room' => 'required|numeric',
            'adt' => 'required|numeric',
            'chd' => 'required|numeric',
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
            ], 400);
        }
        $adt = ($request->adt / $request->room === 1) ? 1 : 2;
        $param = [
            'mmid' => $this->mmid,
            'rqid' => $this->rqid,
            'action' => 'search_hotel',
            'app' => 'information',
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'des' => $request->des,
            'room' => $request->room,
            'roomtype' => $request->roomtype,
            'adt' => $adt,
            'chd' => $request->chd,
        ];
        if ($client->user->username == 'trialdev') {
            $param['mmid'] = 'retross_01';
        }
        $param = json_encode($param);
        $response = SipHotel::search($param)->get();
        if ($response['error_code'] != '000') {
            $this->setStatusMessage($response['error_msg']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $detail = [
            'des' => $request->des,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'room' => $request->room,
            'adt' => $request->adt,
            'chd' => $request->chd,
            'jml' => $response['jml'],
            'next' => $response['next'],
            'hotels' => $response['hotels'],

        ];
        $this->setStatusMessage('Success search hotel');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => $detail,
        ]);
    }

    public function searchByNext(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'des' => 'required|exists:hotel_cities,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'room' => 'required|numeric',
            'adt' => 'required|numeric',
            'chd' => 'required|numeric',
            'next' => 'required|numeric',
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
            ], 400);
        }
        $adt = ($request->adt / $request->room === 1) ? 1 : 2;
        $param = [
            'mmid' => $this->mmid,
            'rqid' => $this->rqid,
            'action' => 'search_next',
            'app' => 'information',
            'checkin' => date('Y-m-d', strtotime($request->checkin_date)),
            'checkout' => date('Y-m-d', strtotime($request->checkout_date)),
            'des' => $request->des,
            'room' => $request->room,
            'roomtype' => $request->roomtype,
            'adt' => $adt,
            'chd' => $request->chd,
            'next' => $request->next,
        ];
        if ($client->user->username == 'trialdev') {
            $param['mmid'] = 'retross_01';
        }
        $param = json_encode($param);
        $response = SipHotel::search($param)->get();
        if ($response['error_code'] != '000') {
            $this->setStatusMessage($response['error_msg']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        unset($response['error_code']);
        unset($response['error_msg']);
        unset($response['mmid']);
        $this->setStatusMessage('Success search hotel');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => $response,
        ]);
    }

    public function searchByKeyword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'des' => 'required|exists:hotel_cities,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'room' => 'required|numeric',
            'adt' => 'required|numeric',
            'chd' => 'required|numeric',
            'next' => 'required|numeric',
            'keyword' => 'required',
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
            ], 400);
        }
        $adt = ($request->adt / $request->room === 1) ? 1 : 2;
        $param = [
            'mmid' => $this->mmid,
            'rqid' => $this->rqid,
            'action' => 'search_keyword',
            'app' => 'information',
            'checkin' => date('Y-m-d', strtotime($request->checkin_date)),
            'checkout' => date('Y-m-d', strtotime($request->checkout_date)),
            'des' => $request->des,
            'room' => $request->room,
            'roomtype' => $request->roomtype,
            'adt' => $adt,
            'chd' => $request->chd,
            'keyword' => $request->keyword,
            'next' => $request->next,
        ];
        if ($client->user->username == 'trialdev') {
            $param['mmid'] = 'retross_01';
        }
        $param = json_encode($param);
        $response = SipHotel::search($param)->get();
        if ($response['error_code'] != '000') {
            $this->setStatusMessage($response['error_msg']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        unset($response['error_code']);
        unset($response['error_msg']);
        unset($response['mmid']);
        $this->setStatusMessage('Success search hotel');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => $response,
        ]);
    }

    public function searchBySort(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'des' => 'required|exists:hotel_cities,id',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'room' => 'required|numeric',
            'adt' => 'required|numeric',
            'chd' => 'required|numeric',
            'next' => 'required|numeric',
            'sort_by' => 'required',
            'type' => 'required',
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
            ], 400);
        }
        $adt = ($request->adt / $request->room === 1) ? 1 : 2;
        $param = [
            'mmid' => $this->mmid,
            'rqid' => $this->rqid,
            'action' => 'sortir',
            'app' => 'information',
            'checkin' => date('Y-m-d', strtotime($request->checkin_date)),
            'checkout' => date('Y-m-d', strtotime($request->checkout_date)),
            'des' => $request->des,
            'room' => $request->room,
            'roomtype' => $request->roomtype,
            'adt' => $adt,
            'chd' => $request->chd,
            'next' => $request->next,
            'sortby' => $request->sort_by,
            'jns' => $request->type,
        ];
        if ($client->user->username == 'trialdev') {
            $param['mmid'] = 'retross_01';
        }
        $param = json_encode($param);
        $response = SipHotel::search($param)->get();
        if ($response['error_code'] != '000') {
            $this->setStatusMessage($response['error_msg']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        unset($response['error_code']);
        unset($response['error_msg']);
        unset($response['mmid']);
        $this->setStatusMessage('Success search hotel');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => $response,
        ]);
    }

    public function hotelDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'selected_id' => 'required',
            'client_id' => 'required',
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
            ], 400);
        }
        $param = [
            'mmid' => $this->mmid,
            'rqid' => $this->rqid,
            'action' => 'detail_hotel',
            'app' => 'information',
            'selectedID' => $request->selected_id,
        ];
        if ($client->user->username == 'trialdev') {
            $param['mmid'] = 'retross_01';
        }
        $param = json_encode($param);
        $hotel = SipHotel::detail($param)->get();
        if ($hotel['error_code'] == '000') {
            $dataHotel = Hotel::firstOrCreate([
                'hotel_city_id' => $hotel['des'],
                'name' => $hotel['details']['data']['name'],
                'rating' => $hotel['details']['data']['rating'],
                'address' => $hotel['details']['data']['address'],
                'email' => $hotel['details']['data']['email'],
                'website' => $hotel['details']['data']['website'],
                'url_image' => (isset($hotel['details']['images'][0])) ? $hotel['details']['images'][0] : 'https://mysmartinpays.com/assets/images/material/unavailable.jpg',
            ]);
            foreach ($hotel['details']['rooms'] as $key => $room) {
                $dataRoom = $dataHotel->rooms()->firstOrCreate([
                    'name' => $room['characteristic'],
                    'bed' => $room['bed'],
                    'board' => $room['board'],
                ]);
                $fare = \App\HotelRoomFare::find($room['selectedIDroom']);
                if (!$fare) {
                    $dataRoom->fares()->save(new \App\HotelRoomFare([
                        'selected_id' => $hotel['selectedID'],
                        'selected_id_room' => $room['selectedIDroom'],
                        'checkin' => $hotel['checkin'],
                        'checkout' => $hotel['checkout'],
                        'price' => $room['price'],
                        'nta' => $room['nta'],
                    ]));
                } else {
                    $fare->selected_id = $hotel['selectedID'];
                    $fare->checkin = $hotel['checkin'];
                    $fare->checkout = $hotel['checkout'];
                    $fare->price = $room['price'];
                    $fare->nta = $room['nta'];
                    $fare->save();
                }
            }
            unset($hotel['error_code']);
            unset($hotel['error_msg']);
            $this->setStatusMessage('Success search detail hotel');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeSuccess(),
                    'confirm' => $this->getConfirmSuccess(),
                    'message' => $this->getStatusMessage(),
                ],
                'details' => $hotel,
            ]);
        }
        $this->setStatusMessage($hotel['error_msg']);
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ], 400);
    }

    public function bookingIssued(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'adt' => 'required|numeric',
            'chd' => 'required|numeric',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
            'des' => 'required|exists:hotel_cities,id',
            'name' => 'required',
//			'password' => 'required',
            'phone_number' => 'required',
            'pr' => 'required|numeric|min:0|max:3',
            'room' => 'required|numeric|min:0',
            'selected_id' => 'required|numeric|exists:hotel_room_fares,selected_id',
            'title' => 'required',
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
            ], 400);
        }
//		$credentials = ['username' => $client->user->username, 'password' => $request->password];
//		$userLogin = Auth::once($credentials);
//		if (!$userLogin) {
//			return Response::json([
//				'status' => [
//					'code' => 400,
//					'confirm' => 'failed',
//					'message' => array('Password tidak sesuai.'),
//				],
//			]);
//		}
        $issuedValidation = $this->issuedValidation($request, $client->user);
        if (!$issuedValidation) {
            $this->setStatusMessage('Issued gagal. Telah ditemukan transaksi dengan data yang sama.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        if ((int)$request->pr > 3) {
            $this->setStatusMessage('Failed, Periksa kembali point Anda');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $price = 0;
        $bed = array();
        $beds = array();
        $hotelId = 1;
        for ($i = 1; $i <= (int)$request->room; $i++) {
            $validator = Validator::make($request->all(), [
                'bed_' . $i => 'required|exists:hotel_room_fares,selected_id_room',
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
            $dataFare = \App\HotelRoomFare::find($request->get('bed_' . $i));
            $price = $price + $dataFare->price;
            $bed[] = $request->get('bed_' . $i);
            $beds[] = $dataFare->hotel_room->id;
            $hotelId = $dataFare->hotel_room->hotel_id;
        }
        if ((int)$request->pr > 0) {
            $point = Point::check($request->user()->id, (int)$request->pr)->get();
            if (!$point) {
                $this->setStatusMessage('Proses issued gagal. Periksa kembali point Anda. Terimakasih.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
        }
        $prValue = \App\PointValue::find(1)->idr;
        $pr = (int)$request->pr * $prValue;
        if (!Deposit::check($client->user->id, $price - $pr)->get()) {
            $this->setStatusMessage('Proses issued gagal. Saldo Anda tidak cukup.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $implodeBed = implode(',', $bed);
        $adt = ($request->adt / $request->room === 1) ? 1 : 2;
        $param = [
            'mmid' => $this->mmid,
            'app' => 'transaction',
            'rqid' => $this->rqid,
            'action' => 'bookingIssued',
            'hotel_id' => $hotelId,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'adt' => $adt,
            'adt_input' => $request->adt,
            'chd' => (int)$request->chd,
            'inf' => 0,
            'room' => (int)$request->room,
            'total_fare' => $price,
            'pr' => $pr,
            'device' => $client->device_type,
            'beds' => $beds,
            'selectedID' => $request->selected_id,
            'selectedIDroom' => $implodeBed,
            'titguest' => $request->title,
            'nmguest' => $request->name,
            'hpguest' => $request->phone_number,
            'noteguest' => trim($request->note),
            'point' => (int)$request->pr,
        ];
        if ($client->user->username == 'trialdev') {
            $param['mmid'] = 'retross_01';
        }
        $response = SipHotel::createTransaction($client->user->id, $param)->get();
        if ($response['status']['code'] != 200) {
            $this->setStatusMessage($response['status']['message']);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
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
            ], 400);
        }
        $userId = $client->user->id;
        if ($request->has('start_date') && $request->has('end_date')) {
            $from = date('Y-m-d', strtotime($request->start_date));
            $until = date('Y-m-d', strtotime($request->end_date));
            if (daysDifference($until, $from) > 31) {
                $this->setStatusMessage('Report hotel yang bisa Anda cek maksimal 31 hari.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
            $transactions = \App\HotelTransaction::where('user_id', $userId)->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->where('status', '!=', 'failed')->get();
            // $results = array();
            // if (count($transactions) > 0) {
            // 	foreach ($transactions as $transaction) {
            // 		if ($transaction->status != 'failed') {
            // 			$results[] = $transaction;
            // 		}
            // 	}
            // }
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

    public function issuedValidation($request, $user)
    {
        $guests = \App\HotelGuest::where('name', '=', $request->name)->get();
        if ($guests) {
            foreach ($guests as $key => $guest) {
                $transaction = $guest->transaction;
                if ($transaction->user_id == $user->id) {
                    if ($transaction->status == 'process' || $transaction->status == 'waiting-issued') {
                        if ($transaction->checkin == $request->checkin) {
                            $hotelFare = \App\HotelRoomFare::where('selected_id', '=', $request->selected_id)->first();
                            if ($hotelFare->hotel_room->hotel_id == $transaction->hotel_id) {
                                return false;
                            }
                        }
                    }
                }
            }
            return true;
        }
        return true;
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
