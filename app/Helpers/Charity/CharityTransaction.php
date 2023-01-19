<?php
namespace App\Helpers\Charity;
/**
 *
 */
use App\Charity;
use App\Helpers\Deposit\Deposit;
use App\User;
use DB;
use Log;

class CharityTransaction {
	private $user;
	private $charity;
	private $nominal;
	function __construct($userId, $charityId, $nominal) {
		$this->user = User::find($userId);
		$this->charity = Charity::find($charityId);
		$this->nominal = $nominal;
	}

	public function doTransfer() {
		DB::beginTransaction();
		try {
			$charity = \App\CharityTransaction::create([
				'charity_id' => $this->charity->id,
				'user_id' => $this->user->id,
				'nominal' => $this->nominal,
			]);

			$debit = Deposit::debit($this->user->id, (int) $this->nominal, 'charity|' . $charity->id . '|Transfer charity program : '
				. $this->charity->title . ' IDR ' . number_format($this->nominal))->get();
			/*
				 [
					'status' => [
						'code' => 200,
						'message' => 'Success debit deposit : IDR ' . $this->totalPrice,
					],
					'response' => [
						'detail' => $history,
					],
				]
			*/
			if ($debit['status']['code'] != 200) {
				$charity->status = 'FAILED';
				$charity->save();
				\App\UserLog::create([
				    'user_id' => $this->user->id,
                    'log' => 'Failed debit transfer charity , Charity id :' .
                        $this->charity->id . '. Nominal . ' . $this->nominal
                ]);
				DB::rollback();
				return [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => 'Failed debit user',
					],
				];
			}
			$credit = Deposit::credit(1, $this->nominal, 'charity|' . $charity->id . '|Transfer dari ' . $this->user->username . ' charity program : '
				. $this->charity->title . ' IDR ' . number_format($this->nominal))->get();
			if ($credit['status']['code'] != 200) {
				$charity->status = 'FAILED';
				$charity->save();
                \App\UserLog::create([
                    'user_id' => $this->user->id,
                    'log' => 'Failed credit transfer charity to mastersip, Charity id :' .
                        $this->charity->id . '. Nominal . ' . $this->nominal
                ]);
				DB::rollback();
				return [
					'status' => [
						'code' => 400,
						'confirm' => 'failed',
						'message' => 'Failed credit to mastersip',
					],
				];
			}
			$charity->status = 'SUCCESS';
			$charity->save();
		} catch (\Exception $e) {
			Log::info('Failed transfer charity from user id : ' . $this->user->id . ' , Charity id :' .
				$this->charity->id . '. Nominal . ' . $this->nominal);
            \App\UserLog::create([
                'user_id' => $this->user->id,
                'log' => 'Failed do transfer charity , Charity id :' .
                    $this->charity->id . '. Nominal . ' . $this->nominal.'. Error : '.$e->getMessage()
            ]);
			return [
				'status' => [
					'code' => 400,
					'confirm' => 'failed',
					'message' => 'failed transfer charity',
				],
			];
		}
        \App\UserLog::create([
            'user_id' => $this->user->id,
            'log' => 'Success transfer charity , Charity id :' .
                $this->charity->id . '. Nominal . ' . $this->nominal
        ]);
		DB::commit();
		return [
			'status' => [
				'code' => 200,
				'confirm' => 'success',
				'message' => 'Success transfer charity',
			],
		];
	}
}