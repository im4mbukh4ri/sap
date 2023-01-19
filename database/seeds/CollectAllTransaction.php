<?php

use Illuminate\Database\Seeder;

class CollectAllTransaction extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		//
		//        $datas = AirlinesBooking::whereBetWeen('created_at',[$request->date." 00:00:00",$request->end_date." 23:59:59"])->where('status','issued')->get();
		// 2017-04-13
		// 2017-04-29 - 78559
		// 2017-05-06 - 94884
		// 2017-05-11 - 108529
		// 2017-05-14 - 116383
		// 2017-05-24 - 139675
		// 2017-06-01 - 165457
		// 2017-06-05 - 181311
		// 2017-06-09 - 196911
		// 2017-06-17 - 226078
		// 2017-06-22 - 245331
		// 2017-06-30 - 273865
		// 2017-07-09 - 316411
		$start = '2017-11-07';
		$end = '2017-11-13';
		$startHotel = '2017-09-16';
		$endHotel = '2017-11-13';

		$hotels = \App\HotelTransaction::whereBetween('created_at', [$startHotel . " 00:00:00", $endHotel . " 23:59:59"])->where('status', 'issued')->get();

		foreach ($hotels as $key => $val) {
			\App\CollectAllTransaction::create([
				'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
				'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
				'id_transaksi' => $val->id,
				'username' => $val->user->username,
				'produk' => 'hotel',
				'nama_produk' => $val->hotel->name . ' (' . $val->voucher->voucher . ')',
				'market_price' => $val->total_fare,
				'smart_value' => floor($val->nta),
				'point_reward' => $val->pr,
				'komisi' => ceil($val->nra),
				'komisi_90' => ceil($val->commission->komisi),
				'komisi_10' => floor($val->commission->free),
				'sip' => $val->commission->pusat,
				'smart_point' => $val->commission->bv,
				'smart_cash' => $val->commission->member,
				'smart_upline' => $val->commission->upline,
				'username_upline' => $val->user->parent->username,
			]);
		}

		$trains = \App\TrainBooking::whereBetWeen('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->where('status', 'issued')->get();
		foreach ($trains as $key => $val) {
			\App\CollectAllTransaction::create([
				'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
				'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
				'id_transaksi' => $val->train_transaction_id,
				'username' => $val->transaction->user->username,
				'produk' => 'train',
				'nama_produk' => $val->train_name . ' ' . $val->class . ' (' . $val->pnr . ')',
				'market_price' => $val->paxpaid + $val->admin,
				'smart_value' => floor($val->nta),
				'point_reward' => $val->pr,
				'komisi' => ceil($val->nra),
				'komisi_90' => ceil($val->commission->komisi),
				'komisi_10' => floor($val->commission->free),
				'sip' => $val->commission->pusat,
				'smart_point' => $val->commission->bv,
				'smart_cash' => $val->commission->member,
				'smart_upline' => $val->commission->upline,
				'username_upline' => $val->transaction->user->parent->username,
			]);
		}
		$airlines = \App\AirlinesBooking::whereBetWeen('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->where('status', 'issued')->get();
		foreach ($airlines as $val) {
			\App\CollectAllTransaction::create([
				'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
				'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
				'id_transaksi' => $val->airlines_transaction_id,
				'username' => $val->transaction->user->username,
				'produk' => 'airlines',
				'nama_produk' => $val->airlines_code . ' (' . $val->itineraries()->first()->pnr . ')',
				'market_price' => $val->paxpaid,
				'smart_value' => floor($val->nta),
				'point_reward' => $val->pr,
				'komisi' => ceil($val->nra),
				'komisi_90' => ceil($val->transaction_commission->komisi),
				'komisi_10' => floor($val->transaction_commission->free),
				'sip' => $val->transaction_commission->pusat,
				'smart_point' => $val->transaction_commission->bv,
				'smart_cash' => $val->transaction_commission->member,
				'smart_upline' => $val->transaction_commission->upline,
				'username_upline' => $val->transaction->user->parent->username,
			]);
		}
		$pulsa = App\PpobTransaction::whereBetWeen('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->where('service', 1)->where('status', 'SUCCESS')->get();
		foreach ($pulsa as $val) {
			\App\CollectAllTransaction::create([
				'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
				'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
				'id_transaksi' => $val->id_transaction,
				'username' => $val->user->username,
				'produk' => 'pulsa',
				'nama_produk' => $val->ppob_service->name,
				'market_price' => $val->paxpaid,
				'smart_value' => floor($val->nta),
				'point_reward' => $val->pr,
				'komisi' => ceil($val->nra),
				'komisi_90' => ceil($val->transaction_commission->komisi),
				'komisi_10' => floor($val->transaction_commission->free),
				'sip' => $val->transaction_commission->pusat,
				'smart_point' => $val->transaction_commission->bv,
				'smart_cash' => $val->transaction_commission->member,
				'smart_upline' => $val->transaction_commission->upline,
				'username_upline' => $val->user->parent->username,
			]);
		}
		$ppob = App\PpobTransaction::whereBetWeen('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->where('service', '<>', 1)->where('status', 'SUCCESS')->get();
		foreach ($ppob as $val) {
			\App\CollectAllTransaction::create([
				'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
				'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
				'id_transaksi' => $val->id_transaction,
				'username' => $val->user->username,
				'produk' => 'ppob',
				'nama_produk' => $val->ppob_service->name,
				'market_price' => $val->paxpaid,
				'smart_value' => floor($val->nta),
				'point_reward' => $val->pr,
				'komisi' => ceil($val->nra),
				'komisi_90' => ceil($val->transaction_commission->komisi),
				'komisi_10' => floor($val->transaction_commission->free),
				'sip' => $val->transaction_commission->pusat,
				'smart_point' => $val->transaction_commission->bv,
				'smart_cash' => $val->transaction_commission->member,
				'smart_upline' => $val->transaction_commission->upline,
				'username_upline' => $val->user->parent->username,
			]);
		}
	}
}
