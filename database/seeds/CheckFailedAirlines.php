<?php
use App\HistoryDeposit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class CheckFailedAirlines extends Seeder {
	private $month = '2017-11';
	public function run() {
		$faileds = HistoryDeposit::where('created_at', 'LIKE', $this->month . '%')
			->where('note', 'LIKE', '%Gagal Issued%')->get();
		Log::info('Gagal Issued ada : ' . count($faileds));

		foreach ($faileds as $key => $value) {
			$searchRefund = HistoryDeposit::where('created_at', 'LIKE', substr($value->created_at, 0, 17) . '%')
				->where('note', 'LIKE', 'airlines%')
				->where('note', 'LIKE', '%Refund%')->first();
			if ($searchRefund) {
				Log::info('id : ' . $value->id . ', Suspect id : ' . $searchRefund->id);
			}
		}
	}
}