<?php

namespace App\Console\Commands;

use App\AirlinesBookingFailedMessage;
use App\Helpers\SipAirlines;
use App\LogCron;
use Illuminate\Console\Command;

class AirlinesTimelimit extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cron:airlines_timelimit';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cancel booking airlines expired';

	/**
	 * Params for send check status
	 * @string rqid
	 * @string mmid
	 * @string app
	 * @string action
	 */
	private $rqid;
	private $mmid;
	private $action;
	private $app;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->rqid = config('sip-config')['rqid'];
		$this->mmid = config('sip-config')['mmid'];
		$this->action = 'cancel';
		$this->app = 'transaction';
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		//
		// $messages = array();
		$bookings = \App\AirlinesBooking::where('status', 'booking')->where('flag', '=', 0)->take(300)->get(); //orWhere('status','booking')->get();
		foreach ($bookings as $booking) {
			$now = time();
			$expired = strtotime($booking->transaction->expired);
			if ($now >= $expired) {
				// $notrx = $booking->transaction_number->transaction_number;

				// $param = [
				// 	'rqid' => $this->rqid,
				// 	'app' => $this->app,
				// 	'action' => $this->action,
				// 	'notrx' => $notrx,
				// ];
				// $attributes = json_encode($param);
				// SipAirlines::GetSchedule($attributes, false)->get();

				$booking->status = 'canceled';
				$booking->save();
				$booking->failed_message()->save(new AirlinesBookingFailedMessage([
					'message' => 'Canceled because of exceeding the time limit'
				]));
				// $messages[] = "Success cancel " . $booking->airline->name . " " .
				// 	$booking->origin . "-" .
				// 	$booking->destination . " (" .
				// 	$booking->itineraries->first()->pnr . ")";
			}
		}
		// $log = '';
		// foreach ($messages as $mess) {
		// 	$log .= $mess . '|';
		// }
		// if ($log != '') {
		// 	LogCron::create(['log' => $log, 'service' => 'Airlines']);
		// }
	}
}
