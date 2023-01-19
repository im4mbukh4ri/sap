<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\OauthAccessToken;
use App\OauthClientSecret;
use App\PointValue;
use App\SipBank;
use App\TicketDeposit;
use App\UniqueCodeTicketDeposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiDepositsController extends Controller
{
    private $confirmSuccess = 'success';
    private $confirmFailed = 'failed';
    private $codeSuccess = 200;
    private $codeFailed = 400;
    private $statusMessage;

    public function __construct(Request $request)
    {
        $this->middleware('oauth');
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

    public function balance(Request $request)
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
        $deposit = $client->user->deposit;
        $this->setStatusMessage('Berhasil cek deposit');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'deposit' => $deposit,
            ],
        ]);
    }

    public function bankList()
    {
        $banks = SipBank::where('status', 1)->get();
        $this->setStatusMessage('Berhasil mendapatkan list bank.');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'banks' => $banks,
            ],
        ]);
    }

    public function ticket(Request $request)
    {
        return [
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => 'Silahkan update aplikasi Anda.',
            ],
        ];
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'nominal' => 'required|numeric',
            'bank_id' => 'required|exists:sip_banks,id',
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        $bank = SipBank::find($request->bank_id);
        if ($bank->status == 0) {
            $this->setStatusMessage('Maaf bank yang Anda pilih sedang kami tutup sementara waktu. Silahkan pilih bank lain. Terimakasih.');
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
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
        $reqDeposit = (int)$request->nominal;
        if ($user->role != 'pro') {
            $limit = PointValue::find($user->type_user_id)->idr;
            $date = date("Y-m-d");
            $starDate = date('Y-m-01', strtotime($date));
            $endDate = date('Y-m-t', strtotime($date));
            $deposit = TicketDeposit::where('user_id', $user->id)
                ->whereBetween('created_at', [$starDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'accepted')->sum('nominal');
            if ((int)($deposit + $reqDeposit) > $limit) {
                $sisa = $limit - $deposit;
                if ($sisa < 0) {
                    $this->setStatusMessage('Tiket deposit gagal. Limit deposit melebihi batas maksimum bulanan. Tiket deposit Anda bulan ini sudah IDR ' . number_format($deposit));
                    return Response::json([
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ]);
                } else {
                    $this->setStatusMessage('Tiket deposit gagal. Limit deposit melebihi batas maksimum bulanan, Sisa limit IDR ' . number_format($sisa));
                    return Response::json([
                        'status' => [
                            'code' => $this->getCodeFailed(),
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ],
                    ]);
                }
            }
        }
        $today = date("Y-m-d", time());
        if ((int)$request->nominal % 50000 != 0) {
            $this->setStatusMessage('Tiket deposit gagal. Tiket deposit harus kelipatan Rp50.000');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $todayTicket = $user->ticket_deposits()->where('status', 'waiting-transfer')
            ->whereBetween('created_at', [$today . ' 00:00:00', $today . ' 23:59:59'])->get();
        if (count($todayTicket) >= 1) {
            $this->setStatusMessage('Tiket deposit gagal. Anda telah melakukan tiket deposit 1X hari ini. Untuk melakukan tiket deposit lagi. Silahkan lakukan transfer untuk tiket sebelumnya.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $unique_code = $this->generateNominal();
        $nominal = $reqDeposit + $unique_code;
        try {
            $user->ticket_deposits()->save($ticket = new TicketDeposit([
                'nominal_request' => $request->nominal,
                'unique_code' => $unique_code,
                'nominal' => $nominal,
                'sip_bank_id' => $request->bank_id,
                'note' => $request->note,
            ]));
        } catch (Exception $e) {
            $this->setStatusMessage('Tiket deposit gagal. Error : ' . $e);
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $this->setStatusMessage('Tiket deposit berhasil');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'ticket' => $ticket,
            ],
        ]);
    }

    public function cancelTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'id' => 'required|exists:ticket_deposits,id',
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
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
        $ticket = TicketDeposit::find($request->id);
        if ($ticket->user_id != $user->id) {
            $this->setStatusMessage('Proses gagal.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        if ($ticket->status == 'cancel') {
            $this->setStatusMessage('Proses gagal.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $ticket->status = 'cancel';
        $ticket->save();
        $this->setStatusMessage('Cancel ticket deposit berhasil.');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
    }

    public function transferDeposit(Request $request)
    {
        if ($request->has('phone_number')) {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'phone_number' => 'required|exists:users,phone_number',
                'nominal' => 'required|numeric',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'username' => 'required|exists:users,username',
                'nominal' => 'required|numeric',
            ]);
        }
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        if ((int)$request->nominal < 1000) {
            $this->setStatusMessage('Transfer deposit gagal,Minimal transfer deposit IDR 1.000');
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
        if ($request->username == $user->username) {
            $this->setStatusMessage('Transfer deposit gagal, Silahkan masukan username yang lain.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
//        $auth = Auth::once(['username' => $user->username, 'password' => $request->password]);
        $auth = true;
        if ($auth) {
            if ((int)$request->nominal % 100 != 0) {
                $this->setStatusMessage('Transfer deposit gagal,Transfer deposit harus kelipatan IDR 100.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
            if ($user->deposit >= $request->nominal) {
                if ($request->has('phone_number')) {
                    $userReceiver = \App\User::where('phone_number', $request->phone_number)->first();
                } else {
                    $userReceiver = \App\User::where('username', $request->username)->first();
                }

                // Start to request deposit
                $request->request->add(['ip' => $request->ip()]);
                $requestTransfer = \App\Helpers\Deposit\Deposit::RequestTransfer([
                    'fromUser' => $user->id,
                    'toUser' => $userReceiver->id,
                    'nominal' => (int)$request->nominal,
                    'note' => trim($request->note),
                    'ip' => $request->ip(),
                    'device' => $client->device_type,
                ])->get();

                if ($requestTransfer['status']['code'] === 200) {
                    $transferDeposit = \App\Helpers\Deposit\Deposit::Transfer($user->id, $requestTransfer['data']['otp'])->get();
                    if ($transferDeposit['status']['code'] === 200) {
                        $requestTransferDeposit = \App\RequestTransferDeposit::find($requestTransfer['data']['id']);
                        $requestTransferDeposit->status = 1;
                        $requestTransferDeposit->save();
                        $this->setStatusMessage('TRANSFER DEPOSIT BERHASIL');
                        return Response::json([
                            'status' => [
                                'code' => 400,
                                'confirm' => $this->getConfirmFailed(),
                                'message' => $this->getStatusMessage(),
                            ]
                        ]);
                    }
                }
                return Response::json($requestTransfer);
            }
            $this->setStatusMessage('Deposit Anda tidak cukup untuk melakukan transfer deposit');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        $this->setStatusMessage('Password salah !');
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
    }

    public function transferPayment(Request $request)
    {
        if ($request->has('phone_number')) {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'phone_number' => 'required|exists:users,phone_number',
                'nominal' => 'required|numeric',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'username' => 'required|exists:users,username',
                'nominal' => 'required|numeric',
            ]);
        }
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
        }
        if ((int)$request->nominal < 1000) {
            $this->setStatusMessage('Transfer deposit gagal,Minimal transfer deposit IDR 1.000');
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
        if ($request->username == $user->username) {
            $this->setStatusMessage('Transfer deposit gagal, Silahkan masukan username yang lain.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
//        if (Auth::once(['username' => $user->username, 'password' => $request->password])) {
        if ((int)$request->nominal % 100 != 0) {
            $this->setStatusMessage('Transfer deposit gagal,Transfer deposit harus kelipatan IDR 100.');
            return Response::json([
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ]);
        }
        if ($user->deposit >= $request->nominal) {
            if ($request->has('phone_number')) {
                $userReceiver = \App\User::where('phone_number', $request->phone_number)->first();
            } else {
                $userReceiver = \App\User::where('username', $request->username)->first();
            }
            // Start to request deposit
            $request->request->add(['ip' => $request->ip()]);
            $requestTransfer = \App\Helpers\Deposit\Deposit::RequestPayment([
                'fromUser' => $user->id,
                'toUser' => $userReceiver->id,
                'nominal' => (int)$request->nominal,
                'note' => trim($request->note),
                'ip' => $request->ip(),
                'device' => $client->device_type,
            ])->get();

            if ($requestTransfer['status']['code'] === 200) {
                $transferDeposit = \App\Helpers\Deposit\Deposit::Payment($user->id, $requestTransfer['data']['otp'])->get();
                if ($transferDeposit['status']['code'] === 200) {
                    $requestTransferDeposit = \App\RequestTransferDeposit::find($requestTransfer['data']['id']);
                    $requestTransferDeposit->status = 1;
                    $requestTransferDeposit->save();
                    $this->setStatusMessage('PAYMENT BERHASIL');
                    return Response::json([
                        'status' => [
                            'code' => 400,
                            'confirm' => $this->getConfirmFailed(),
                            'message' => $this->getStatusMessage(),
                        ]
                    ]);
                }
            }
            return Response::json($requestTransfer);
        }
        $this->setStatusMessage('Deposit Anda tidak cukup untuk melakukan transfer deposit');
        return Response::json([
            'status' => [
                'code' => $this->getCodeFailed(),
                'confirm' => $this->getConfirmFailed(),
                'message' => $this->getStatusMessage(),
            ],
        ]);
//        }
//        $this->setStatusMessage('Password salah !');
//        return Response::json([
//            'status' => [
//                'code' => $this->getCodeFailed(),
//                'confirm' => $this->getConfirmFailed(),
//                'message' => $this->getStatusMessage(),
//            ],
//        ]);
    }

    public function doTransferDeposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|exists:request_transfer_deposits,otp',
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
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
        $transferDeposit = \App\Helpers\Deposit\Deposit::Transfer($user->id, $request->otp)->get();
        return Response::json($transferDeposit);
    }

    public function transferHistories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->setStatusMessage($validator->errors());
            return [
                'status' => [
                    'code' => $this->getCodeFailed(),
                    'confirm' => $this->getConfirmFailed(),
                    'message' => $this->getStatusMessage(),
                ],
            ];
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
        $time = time();
        $date = date('Y-m-d', $time);
        $deposits = \App\Deposit::where('created_at', 'LIKE', $date . '%')->where('user_id', '<>', $client->user->id)->where('created_by', $client->user->id)->get()->sortByDesc('id');
        $this->setStatusMessage('Berhasil mendapatkan history transfer');
        return Response::json([
            'status' => [
                'code' => $this->getCodeSuccess(),
                'confirm' => $this->getConfirmSuccess(),
                'message' => $this->getStatusMessage(),
            ],
            'details' => [
                'transfer_histories' => $deposits,
            ],
        ]);
    }

    public function ticketHistories(Request $request)
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
                $this->setStatusMessage('History deposit yang bisa Anda cek maksimal 31 hari.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
            $histories = $user->ticket_deposits()
                ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get();
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
            'details' => [
                'ticket_histories' => $histories,
            ],
        ]);
    }

    public function depositHistories(Request $request)
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
                $this->setStatusMessage('History deposit yang bisa Anda cek maksimal 31 hari.');
                return Response::json([
                    'status' => [
                        'code' => $this->getCodeFailed(),
                        'confirm' => $this->getConfirmFailed(),
                        'message' => $this->getStatusMessage(),
                    ],
                ]);
            }
            $histories = $user->history_deposits()
                ->whereBetween('created_at', [$from . ' 00:00:00', $until . ' 23:59:59'])->get();
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
            'details' => [
                'deposit_histories' => $histories,
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

    private function generateNominal()
    {
        $unique = UniqueCodeTicketDeposit::where('is_available', '=', 1)->first();
        $unique->is_available = 0;
        $unique->save();
        return $unique->id;
    }
}
