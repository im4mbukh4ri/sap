<?php
/**
 * Created by Mochamad Ramdhanie Mubarak.
 * User: dhaniemubarak
 * Date: 03/11/16
 * Time: 9:04
 */

namespace App\Helpers\Deposit;

use App\HistoryDeposit;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

abstract class DepositService
{
    protected $totalPrice;
    protected $deposit;
    protected $response;
    protected $endDeposit;
    protected $user;

    public function __construct($userId)
    {
        $this->user = User::find($userId);
    }

    public function check()
    {
        $depositUser = $this->balance();
        $total = (int)$this->totalPrice;
        if ($total <= 0) {
            $this->response = false;
            return;
        }
        if ($depositUser < $total) {
            $this->response = false;
        } else {
            $this->response = true;
        }
    }

    public function balance()
    {
        $this->deposit = $this->user->deposit;
        return $this->response = $this->deposit;
    }

    public function debitDeposit($transactionId)
    {
        $deposit = 0;
        $debit = 0;
        $this->check();
        if ($this->get()) {
            DB::beginTransaction();
            try {
                $deposit = (float)$this->deposit;
                $debit = (int)$this->totalPrice;
                $newDeposit = $deposit - $debit;
                $update = DB::table('users')->where('id', $this->user->id)
                    ->where('deposit', '=', $deposit)->update(['deposit' => $newDeposit]);
                if (!$update) {
                    DB::rollback();
                    Log::info('Failed debit deposit. Deposit not change. Transaction id : ' . $transactionId);
                    return $this->response = [
                        'status' => [
                            'code' => 400,
                            'message' => 'Failed debit deposit. Deposit not change. Transaction id : ' . $transactionId,
                        ],
                    ];
                }
                // if (!($this->user->deposit < $deposit) || !($this->user->deposit == $newDeposit)) {

                // }
                $this->user->history_deposits()->save($history = new HistoryDeposit([
                    'deposit' => $deposit,
                    'debit' => $debit,
                    'credit' => 0,
                    'note' => $transactionId,
                ]));
            } catch (\Exception $e) {
                DB::rollback();
                Log::info('Failed debit deposit. error : ' . $e->getMessage());
                return $this->response = [
                    'status' => [
                        'code' => 400,
                        'message' => $e->getMessage(),
                    ],
                ];
            }
            DB::commit();
            return $this->response = [
                'status' => [
                    'code' => 200,
                    'message' => 'Success debit deposit : IDR ' . $this->totalPrice,
                ],
                'response' => [
                    'detail' => $history,
                ],
            ];
        }
        return $this->response = [
            'status' => [
                'code' => 400,
                'message' => 'Your deposit not enough. Deposit : IDR ' . $this->deposit,
            ],
        ];
    }

    public function creditDeposit($transactionId)
    {
        $this->check();
//        $checkHistory = HistoryDeposit::where('user_id', '=', $this->user->id)->where('credit', '=', (int) $this->totalPrice)->where('note', '=', $transactionId)->first();
//        if($checkHistory){
//            return $this->response = [
//                'status' => [
//                    'code' => 200,
//                    'message' => 'Success credit deposit : IDR ' . $credit,
//                ],
//                'response' => [
//                    'detail' => '',
//                ],
//            ];
//        }
        DB::beginTransaction();
        try {
            $deposit = (float)$this->deposit;
            $credit = (int)$this->totalPrice;
            if ($credit <= 0) {
                return $this->response = [
                    'status' => [
                        'code' => 400,
                        'message' => 'Failed debit deposit'
                    ],
                ];
            }
            $newDeposit = $deposit + $credit;
            $update = DB::table('users')->where('id', $this->user->id)
                ->where('deposit', '=', $deposit)->update(['deposit' => $newDeposit]);
            if (!$update) {
                DB::rollback();
                Log::info('Failed credit deposit. Deposit not change. Transaction id : ' . $transactionId);
                return $this->response = [
                    'status' => [
                        'code' => 400,
                        'message' => 'Failed debit deposit. Deposit not change. Transaction id : ' . $transactionId,
                    ],
                ];
            }
            $this->user->history_deposits()->save($history = new HistoryDeposit([
                'deposit' => $deposit,
                'debit' => 0,
                'credit' => $credit,
                'note' => $transactionId,
            ]));
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('Failed credit deposit. error : ' . $e->getMessage());
            return $this->response = [
                'status' => [
                    'code' => 400,
                    'message' => $e->getMessage(),
                ],
            ];
        }
        DB::commit();
        return $this->response = [
            'status' => [
                'code' => 200,
                'message' => 'Success credit deposit : IDR ' . $this->totalPrice,
            ],
            'response' => [
                'detail' => $history,
            ],
        ];
    }

    public function get()
    {
        return $this->response;
    }
}
