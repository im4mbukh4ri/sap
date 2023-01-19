<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DepositCorrection extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$userId = 43794;
		$finalDeposit = 510089;
		$histories = App\HistoryDeposit::where('user_id', '=', $userId)
			->whereBetween('created_at', ['2017-09-01 00:00:00', '2017-09-13 23:59:59'])
			->get();
		foreach ($histories as $key => $value) {
			DB::beginTransaction();
			try {
				$value->deposit = $finalDeposit;
				$value->save();
				$debit = $value->debit;
				$credit = $value->credit;
				$finalDeposit = $finalDeposit - $debit + $credit;

			} catch (Exception $e) {
				Log::info('Failed correction with id history : ' . $value->id);
				DB::rollback();
				break;
			}
			DB::commit();
		}
	}
}
