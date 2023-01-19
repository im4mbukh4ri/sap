<?php

namespace App\Console\Commands;

use App\AirlinesBookingFailedMessage;
use App\Helpers\Deposit\Deposit;
use App\Helpers\Point\Point;
use App\Helpers\SipAirlines;
use App\HistoryDeposit;
use App\LogCron;
use App\PointValue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AirlinesStatus extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cron:airlines_status';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check status airlines';

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
	public function __construct() {
		parent::__construct();
		$this->rqid = config('sip-config')['rqid'];
		$this->mmid = config('sip-config')['mmid'];
		$this->action = 'get_trx_detail';
		$this->app = 'information';
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		//
		$messages = array();
		$bookings = \App\AirlinesBooking::where('status', 'waiting-issued')->where('flag', '=', 0)->get(); //orWhere('status','booking')->get();
		foreach ($bookings as $booking) {
			$international = 0;
			if ($booking->paxpaid == $booking->nta) {
				$international = 1;
			}
//            if($booking->status=='booking'){
			//                $now=Carbon::now();
			//                $expired=Carbon::createFromFormat('Y-m-d H:i:s',$booking->transaction->expired);
			//                if($expired->diffInHours($now,false)>=2){
			//                    $notrx=$booking->transaction_number->transaction_number;
			//
			//                    $param=[
			//                        'rqid'=>$this->rqid,
			//                        'mmid'=>$this->mmid,
			//                        'app'=>$this->app,
			//                        'action'=>$this->action,
			//                        'notrx'=>$notrx
			//                    ];
			//                    $attributes=json_encode($param);
			//                    $status=SipAirlines::GetSchedule($attributes,false)->get();
			//                    if($status['error_code']=='000'){
			//                        if($status['status']=='CANCELED'){
			//                            //foreach ($booking->transaction->bookings as $value){
			//                                $booking->status='canceled';
			//                                $booking->save();
			//                                $messages[]="Success change status from booking to canceled ".$booking->airline->name." ".
			//                                    $booking->origin."-".
			//                                    $booking->destination." (".
			//                                    $booking->itineraries->first()->pnr.")";
			//                            //}
			//                        }elseif($status['status']!='ISSUED'){
			//                            $param=[
			//                                'rqid'=>$this->rqid,
			//                                'mmid'=>$this->mmid,
			//                                'app'=>'transaction',
			//                                'action'=>'cancel',
			//                                'notrx'=>$booking->transaction_number->transaction_number
			//                            ];
			//                            $attributes=json_encode($param);
			//                            $result=SipAirlines::GetSchedule($attributes,false)->get();
			//                            if($result['error_code']=="000"){
			//                                //foreach ($booking->transaction->bookings as $value){
			//                                    $booking->status='canceled';
			//                                    $booking->save();
			//                                    $messages[]="Success change status from booking to canceled ".$booking->airline->name." ".
			//                                        $booking->origin."-".
			//                                        $booking->destination." (".
			//                                        $booking->itineraries->first()->pnr.")";
			//                                //}
			//                            }else{
			//                                $messages[]="Failed change status from booking to canceled ".$booking->airline->name." ".
			//                                    $booking->origin."-".
			//                                    $booking->destination." (".
			//                                    $booking->itineraries->first()->pnr.")";
			//                            }
			//                        }else{
			//                            $messages[]="Didn't change anything . ".$booking->airline->name." ".
			//                                $booking->origin."-".
			//                                $booking->destination." (".
			//                                $booking->itineraries->first()->pnr.")";
			//                        }
			//                    }else{
			//                        $messages[]="Failed check status. Error : 002 . ".$booking->airline->name." ".
			//                            $booking->origin."-".
			//                            $booking->destination." (".
			//                            $booking->itineraries->first()->pnr.")";
			//                    }
			//                }
			//            }else{
			$notrx = $booking->transaction_number->transaction_number;

			$param = [
				'rqid' => $this->rqid,
				'mmid' => $this->mmid,
				'app' => $this->app,
				'action' => $this->action,
				'notrx' => $notrx,
			];
			$attributes = json_encode($param);
			if ($booking->itineraries->first()->class == "economy" || $booking->itineraries->first()->class == "busines") {
				$international = 1;
				$status = SipAirlines::GetSchedule($attributes, true)->get();
			} else {
				$status = SipAirlines::GetSchedule($attributes, false)->get();
			}
			if ($status['error_code'] == '000') {
				if ($booking->origin == $status['org']) {
					if ($status['status'] == 'CANCELED') {
						if ($booking->status == 'waiting-issued') {
							$pointValue = PointValue::find(1)->idr;
							$newStatus = 'canceled';
							$booking->status = $newStatus;
                            $booking->save();
                            $credit = $booking->paxpaid - $booking->pr;
                            if($booking->transaction->bookable){
                                $credit = $credit - $booking->transaction_commission->member;
                            }
                            $note = 'airlines|' . $booking->airlines_transaction_id . '|Refund ' .
                                $booking->airline->name . " " .
                                $booking->origin . "-" .
                                $booking->destination . " (" .
                                $booking->itineraries->first()->pnr . ")";
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed refund '.$note.'. Has been refunded';
                                continue;
                            }
							Deposit::credit($booking->transaction->user_id, $credit, $note);
							if ($booking->pr > 0) {
								$point = floor($booking->pr / $pointValue);
								Point::credit($booking->transaction->user_id, $point, 'airlines|' . $booking->airlines_transaction_id . '|Refund ' .
									$booking->airline->name . " " .
									$booking->origin . "-" .
									$booking->destination . " (" .
									$booking->itineraries->first()->pnr . ")");
							}
							// Disini kasih note gagal.
							$booking->failed_message()->save(new AirlinesBookingFailedMessage([
								'message' => $status['note'],
							]));
							$messages[] = "Success refund " . $booking->airline->name . " " .
							$booking->origin . "-" .
							$booking->destination . " (" .
							$booking->itineraries->first()->pnr . ")";
						} else {
							$newStatus = 'canceled';
							$booking->status = $newStatus;
							$booking->save();
							$booking->failed_message()->save(new AirlinesBookingFailedMessage([
								'message' => $status['note'],
							]));
							$messages[] = "Success change status to cancel " . $booking->airline->name . " " .
							$booking->origin . "-" .
							$booking->destination . " (" .
							$booking->itineraries->first()->pnr . ")";
						}
					} elseif ($status['status'] == 'ISSUED') {
						Log::info("Masuk  ISSUED org=org");
						$oldPaxpaid = $booking->paxpaid;
						//$oldNRA=$booking->nra;
						//                            $booking->transaction->total_fare=floatval($status['harga']['paxpaid']);
						//                            $booking->transaction->save();
						$booking->status = 'issued';
						$booking->paxpaid = floatval($status['harga']['paxpaid']);
						if (isset($status['harga']['nta'])) {
							$booking->nta = ceil($status['harga']['nta']);
							$booking->nra = floatval($status['harga']['paxpaid']) - floatval($status['harga']['nta']);
						} else {
							$booking->nta = ceil($status['harga']['NTA']);
							$booking->nra = floatval($status['harga']['paxpaid']) - floatval($status['harga']['NTA']);
						}
						$booking->save();
						if (isset($status['cabin'])) {
							foreach ($status['schedule']['departure']['Flights'] as $key => $value) {
								$itinerary = $booking->itineraries()->where('depart_return_id', 'd')->where('flight_number', $value['FlightNo'])->first();
								$itinerary->pnr = $value["PNR"];
								$itinerary->save();
							}
							if ($status['flight'] == "R") {
								foreach ($status['schedule']['return']['Flights'] as $key => $value) {
									$itinerary = $booking->itineraries()->where('depart_return_id', 'r')->where('flight_number', $value['FlightNo'])->first();
									$itinerary->pnr = $value["PNR"];
									$itinerary->save();
								}
							}
						} else {
							foreach ($booking->itineraries as $itinerary) {
								$itinerary->pnr = $status['schedule']['departure']['pnr'];
								$itinerary->save();
							}
						}
						if ($booking->transaction->user->role != 'free') {
							$percentPusat = $booking->transaction->user->type_user->pusat_airlines->commission;
							$percentBv = $booking->transaction->user->type_user->bv_airlines->commission;
							$percentMember = $booking->transaction->user->type_user->member_airlines->commission;
							$nra = (int) $booking->nra;
							$komisi = floor(intval($nra) * intval(config('sip-config')['member_commission']) / 100);
							$free = intval($nra) - intval($komisi);
							$pusat = intval(($komisi * $percentPusat) / 100);
							$bv = intval(($komisi * $percentBv) / 100);
							$member = intval(($komisi * $percentMember) / 100);
							$upline = 0;
						} else {
							$percentPusat = $booking->transaction->user->parent->type_user->pusat_airlines->commission;
							$percentBv = $booking->transaction->user->parent->type_user->bv_airlines->commission;
							$percentMember = $booking->transaction->user->parent->type_user->member_airlines->commission;
							$nra = (int) $booking->nra;
							$komisi = floor(intval($nra) * intval(config('sip-config')['member_commission']) / 100);
							$free = intval($nra) - intval($komisi);
							$pusat = intval(($komisi * $percentPusat) / 100);
							$bv = intval(($komisi * $percentBv) / 100);
							$member = intval(($komisi * $percentMember) / 100);
							$comFree = ($member * $booking->transaction->user->type_user->member_airlines->commission) / 100;
							$comSIP = ($member * $booking->transaction->user->type_user->pusat_airlines->commission) / 100;
							$pusat = $pusat + $comSIP;
							$upline = $member - $comFree - $comSIP;
							$member = $comFree;
						}
						$oldMember = $booking->transaction_commission->member;
						$booking->transaction_commission->nra = $nra;
						$booking->transaction_commission->komisi = $komisi;
						$booking->transaction_commission->free = $free;
						$booking->transaction_commission->pusat = $pusat;
						$booking->transaction_commission->bv = $bv;
						$booking->transaction_commission->member = $member;
						$booking->transaction_commission->upline = $upline;
						$booking->transaction_commission->save();
						$credit = $member;
						if ((int) $oldPaxpaid > (int) $status['harga']['paxpaid']) {
                            $paxpaid = 0;
                            foreach ($booking->transaction->bookings as $val) {
                                $paxpaid+= (int) $val->paxpaid;
                            }
                            $booking->transaction->total_fare = $paxpaid;
							$booking->transaction->save();
                            $credit = (int) $oldPaxpaid - (int) $status['harga']['paxpaid'] - (int) $oldMember;
                            $note = "airlines|" . $booking->airlines_transaction_id . "|Kredit selisih harga " .
                                $booking->airline->name . " " .
                                $booking->origin . "-" .
                                $booking->destination . " (" .
                                $booking->itineraries->first()->pnr . ")";
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed credit '.$note.'. Has been credit';
                                continue;
                            }
							Deposit::credit($booking->transaction->user_id, $credit, $note);
						}

						//BUKAN YANG INI YANG GA ADA KETERANGANNYA
						$note = "airlines|" . $booking->airlines_transaction_id . "|Credit Smart Cash " .
						$booking->airline->name . " " .
						$booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")";

						if ($international === 1) {
                            $credit = $member;
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed credit '.$note.'. Has been credit';
                                continue;
                            }
							Deposit::credit($booking->transaction->user_id, $credit, $note)->get();
						}
                        if ($booking->transaction->user->role == 'free') {
                            $note = "airlines|" . $booking->airlines_transaction_id . "|Credit Referal dari " . $booking->transaction->user->name . ' ' .
                                $booking->airline->name . " " .
                                $booking->origin . "-" .
                                $booking->destination;
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user->upline)->where('credit', '=', $upline)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed credit '.$note.'. Has been credit';
                                continue;
                            }
                            Deposit::credit($booking->transaction->user->upline, $upline, $note)->get();
                        }
                        foreach ($status['penumpang'] as $value) {
                            $passenger = $booking->transaction->passengers()->where('title','=',$value['title'])->where('first_name', '=', $value['fn'])
                                ->where('last_name', '=', $value['ln'])->first();
                            if($passenger){
                                $passenger->departure_ticket_number = $value['noticket'];
                                $passenger->save();
                                if($status['flight'] == 'R') {
                                    $passenger->return_ticket_number = $value['noticket_ret'];
                                    $passenger->save();
                                }
                            }
                        }
						$messages[] = "Success change status to issued " . $booking->airline->name . " " .
						$booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")";
					} else {
						$messages[] = 'Didn\'t change anything' . $booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")";
					}
				} else {
					if ($status['status_ret'] == 'CANCELED') {
						if ($booking->status == 'waiting-issued') {
							$pointValue = PointValue::find(1)->idr;
							$newStatus = 'canceled';
							$booking->status = $newStatus;
							$booking->save();
                            $credit = $booking->paxpaid - $booking->transaction_commission->member - $booking->pr;
                            $note = "airlines|" . $booking->airlines_transaction_id . "|Refund " .
                                $booking->airline->name . " " .
                                $booking->origin . "-" .
                                $booking->destination . " (" .
                                $booking->itineraries->first()->pnr . ")";
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed refund '.$note.'. Has been refunded';
                                continue;
                            }
							Deposit::credit($booking->transaction->user_id,$credit , $note);
							if ($booking->pr > 0) {
								$point = floor($booking->pr / $pointValue);
								Point::credit($booking->transaction->user_id, $point, "airlines|" . $booking->airlines_transaction_id . "|Refund " .
									$booking->airline->name . " " .
									$booking->origin . "-" .
									$booking->destination . " (" .
									$booking->itineraries->first()->pnr . ")");
							}
							$messages[] = "Success refund " . $booking->airline->name . " " .
							$booking->origin . "-" .
							$booking->destination . " (" .
							$booking->itineraries->first()->pnr . ")";
						} else {
							$newStatus = 'canceled';
							$booking->status = $newStatus;
							$booking->save();
							$messages[] = "Success change status to cancel " . $booking->airline->name . " " .
							$booking->origin . "-" .
							$booking->destination . " (" .
							$booking->itineraries->first()->pnr . ")";
						}
					} elseif ($status['status_ret'] == 'ISSUED') {
						Log::info("Masuk Issued org!=org");
						$oldPaxpaid = $booking->paxpaid;
//                            $booking->transaction->total_fare=$booking->transaction->total_fare+floatval($status['harga']['paxpaid_ret']);
						//                            $booking->transaction->save();
						$booking->status = 'issued';
						$booking->paxpaid = floatval($status['harga']['paxpaid_ret']);
						$booking->nta = ceil($status['harga']['nta_ret']);
						$booking->nra = floatval($status['harga']['paxpaid_ret']) - ceil($status['harga']['nta_ret']);
						$booking->save();
						foreach ($booking->itineraries as $itinerary) {
							$itinerary->pnr = $status['schedule']['return']['pnr'];
							$itinerary->save();
						}
						if ($booking->transaction->user->role != 'free') {
							$percentPusat = $booking->transaction->user->type_user->pusat_airlines->commission;
							$percentBv = $booking->transaction->user->type_user->bv_airlines->commission;
							$percentMember = $booking->transaction->user->type_user->member_airlines->commission;
							$nra = $booking->nra;
							$komisi = floor(intval($nra) * intval(config('sip-config')['member_commission']) / 100);
							$free = intval($nra) - intval($komisi);
							$pusat = intval(($komisi * $percentPusat) / 100);
							$bv = intval(($komisi * $percentBv) / 100);
							$member = intval(($komisi * $percentMember) / 100);
							$upline = 0;
						} else {
							$percentPusat = $booking->transaction->user->parent->type_user->pusat_airlines->commission;
							$percentBv = $booking->transaction->user->parent->type_user->bv_airlines->commission;
							$percentMember = $booking->transaction->user->parent->type_user->member_airlines->commission;
							$nra = $booking->nra;
							$komisi = floor(intval($nra) * intval(config('sip-config')['member_commission']) / 100);
							$free = intval($nra) - intval($komisi);
							$pusat = intval(($komisi * $percentPusat) / 100);
							$bv = intval(($komisi * $percentBv) / 100);
							$member = intval(($komisi * $percentMember) / 100);
							$comFree = ($member * $booking->transaction->user->type_user->member_airlines->commission) / 100;
							$comSIP = ($member * $booking->transaction->user->type_user->pusat_airlines->commission) / 100;
							$pusat = $pusat + $comSIP;
							$upline = $member - $comFree - $comSIP;
							$member = $comFree;
						}
						$oldMember = $booking->transaction_commission->member;
						$booking->transaction_commission->nra = $nra;
						$booking->transaction_commission->komisi = $komisi;
						$booking->transaction_commission->free = $free;
						$booking->transaction_commission->pusat = $pusat;
						$booking->transaction_commission->bv = $bv;
						$booking->transaction_commission->member = $member;
						$booking->transaction_commission->upline = $upline;
						$booking->transaction_commission->save();
						$credit = $member;
						if ((int) $oldPaxpaid > (int) $status['harga']['paxpaid_ret']) {
							$paxpaid = 0;
							foreach ($booking->transaction->bookings as $val) {
								$paxpaid+= (int) $val->paxpaid;
							}
							$booking->transaction->total_fare = $paxpaid;
							$booking->transaction->save();
                            $credit = (int) $oldPaxpaid - (int) $status['harga']['paxpaid_ret'] - (int) $oldMember;
                            $note = "airlines|" . $booking->airlines_transaction_id . "|Kredit selisih harga " .
                                $booking->airline->name . " " .
                                $booking->origin . "-" .
                                $booking->destination . " (" .
                                $booking->itineraries->first()->pnr . ")";
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed refund '.$note.'. Has been refunded';
                                continue;
                            }
							Deposit::credit($booking->transaction->user_id, $credit, $note);
						}
						if ($international === 1) {
                            $credit = $member;
                            $note = "airlines|" . $booking->airlines_transaction_id . "|Credit Smart Cash " .
                                $booking->airline->name . " " .
                                $booking->origin . "-" .
                                $booking->destination . " (" .
                                $booking->itineraries->first()->pnr . ")";
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user_id)->where('credit', '=', $credit)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed refund '.$note.'. Has been refunded';
                                continue;
                            }
							Deposit::credit($booking->transaction->user_id, $credit, $note);
						}
                        if ($booking->transaction->user->role == 'free') {
                            $note = "airlines|" . $booking->airlines_transaction_id . "|Credit Referal dari " . $booking->transaction->user->name . ' ' .
                                $booking->airline->name . " " .
                                $booking->origin . "-" .
                                $booking->destination;
                            $checkRefund = HistoryDeposit::where('user_id', '=', $booking->transaction->user->upline)->where('credit', '=', $upline)->where('note', '=', $note)->first();

                            if ($checkRefund) {
                                $messages[] = 'Failed credit '.$note.'. Has been credit';
                                continue;
                            }
                            Deposit::credit($booking->transaction->user->upline, $upline, $note)->get();
                        }
						$messages[] = "Success change status to issued " . $booking->airline->name . " " .
						$booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")";
					} else {
						$messages[] = 'Didn\'t change anything' . $booking->origin . "-" .
						$booking->destination . " (" .
						$booking->itineraries->first()->pnr . ")";
					}
				}
//                    if($status['status']=='CANCELED'){
				//                        if($booking->status=='waiting-issued'){
				//                            $pointValue=PointValue::find(1)->idr;
				//                            $newStatus='canceled';
				//                            $booking->status=$newStatus;
				//                            $booking->save();
				//                            Deposit::credit($booking->transaction->user_id,$booking->paxpaid-$booking->transaction_commission->member-$booking->pr,'airlines|'.$booking->airlines_transaction_id.'|Refund '.
				//                                $booking->airline->name." ".
				//                                $booking->origin."-".
				//                                $booking->destination." (".
				//                                $booking->itineraries->first()->pnr.")");
				//                            if($booking->pr>0){
				//                                $point=floor($booking->pr/$pointValue);
				//                                Point::credit($booking->transaction->user_id,$point,'airlines|'.$booking->airlines_transaction_id.'|Refund '.
				//                                    $booking->airline->name." ".
				//                                    $booking->origin."-".
				//                                    $booking->destination." (".
				//                                    $booking->itineraries->first()->pnr.")");
				//                            }
				//                            $messages[] = "Success refund ".$booking->airline->name." ".
				//                                $booking->origin."-".
				//                                $booking->destination." (".
				//                                $booking->itineraries->first()->pnr.")";
				//                        }else{
				//                            $newStatus='canceled';
				//                            $booking->status=$newStatus;
				//                            $booking->save();
				//                            $messages[] = "Success change status to cancel ".$booking->airline->name." ".
				//                                $booking->origin."-".
				//                                $booking->destination." (".
				//                                $booking->itineraries->first()->pnr.")";
				//                        }
				//                    if($status['status']=='ISSUED'){
				//                        if($booking->origin==$status['org']){
				//                            $oldPaxpaid=$booking->paxpaid;
				//                            $oldNRA=$booking->nra;
				//                            $booking->status='issued';
				//                            $booking->paxpaid=floatval($status['harga']['paxpaid']);
				//                            $booking->nra=floor($status['harga']['komisi']);
				//                            $booking->nta=ceil($status['harga']['nta']);
				//                            $booking->save();
				//                            foreach ($booking->itineraries as $itinerary){
				//                                $itinerary->pnr=$status['schedule']['departure']['pnr'];
				//                                $itinerary->save();
				//                            }
				//                            $percentPusat=$booking->transaction->user->type_user->pusat_airlines->commission;
				//                            $percentBv=$booking->transaction->user->type_user->bv_airlines->commission;
				//                            $percentMember=$booking->transaction->user->type_user->member_airlines->commission;
				//                            $nra = intval($status['harga']['komisi']);
				//                            $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
				//                            $free = intval($nra)-intval($komisi);
				//                            $pusat = intval(($komisi * $percentPusat)/100);
				//                            $bv = intval(($komisi * $percentBv)/100);
				//                            $member= intval(($komisi * $percentMember)/100);
				//                            $oldMember=$booking->transaction_commission->member;
				//                            $booking->transaction_commission->nra=$nra;
				//                            $booking->transaction_commission->komisi=$komisi;
				//                            $booking->transaction_commission->free=$free;
				//                            $booking->transaction_commission->pusat=$pusat;
				//                            $booking->transaction_commission->bv=$bv;
				//                            $booking->transaction_commission->member=$member;
				//                            $booking->transaction_commission->save();
				//                            $credit=$member;
				//                            if((int)$oldPaxpaid>(int)$status['harga']['paxpaid']){
				//                                Deposit::credit($booking->transaction->user_id,(int)$oldPaxpaid-(int)$status['harga']['paxpaid']-(int)$oldMember,'airlines|'.$booking->airlines_transaction_id.'|Kredit selisih harga '.
				//                                    $booking->airline->name." ".
				//                                    $booking->origin."-".
				//                                    $booking->destination." (".
				//                                    $booking->itineraries->first()->pnr.")");
				//                            }
				//                            Deposit::credit($booking->transaction->user_id,$credit,'airlines|'.$booking->airlines_transaction_id.'|Credit Smart Cash '.
				//                                $booking->airline->name." ".
				//                                $booking->origin."-".
				//                                $booking->destination." (".
				//                                $booking->itineraries->first()->pnr.")");
				//                            if($oldPaxpaid!=floatval($status['harga']['paxpaid'])||$oldNRA!=floatval($status['harga']['komisi'])){
				//                                Log::info('masuk ke sleksi pertama');
				//                                $booking->status='issued';
				//                                $booking->paxpaid=floatval($status['harga']['paxpaid']);
				//                                $booking->nra=floor($status['harga']['komisi']);
				//                                $booking->nta=ceil($status['harga']['nta']);
				//                                $booking->save();
				//                                foreach ($booking->itineraries as $itinerary){
				//                                    $itinerary->pnr=$status['schedule']['departure']['pnr'];
				//                                    $itinerary->save();
				//                                }
				//                                if($oldNRA!=floatval($status['harga']['komisi'])){
				//                                    $percentPusat=$booking->transaction->user->type_user->pusat_airlines->commission;
				//                                    $percentBv=$booking->transaction->user->type_user->bv_airlines->commission;
				//                                    $percentMember=$booking->transaction->user->type_user->member_airlines->commission;
				//                                    $nra = intval($status['harga']['komisi']);
				//                                    $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
				//                                    $free = intval($nra)-intval($komisi);
				//                                    $pusat = intval(($komisi * $percentPusat)/100);
				//                                    $bv = intval(($komisi * $percentBv)/100);
				//                                    $member= intval(($komisi * $percentMember)/100);
				//                                    $oldMember=$booking->transaction_commission->member;
				//                                    $booking->transaction_commission->nra=$nra;
				//                                    $booking->transaction_commission->komisi=$komisi;
				//                                    $booking->transaction_commission->free=$free;
				//                                    $booking->transaction_commission->pusat=$pusat;
				//                                    $booking->transaction_commission->bv=$bv;
				//                                    $booking->transaction_commission->member=$member;
				//                                    $booking->transaction_commission->save();
				//                                    Log::info('Selesai update NRA dan commission');
				//                                    Log::info('$oldMEmber = '.$oldMember.', $member = '.$member);
				//                                    if($oldMember<$member){
				//                                        Log::info('Masuk ke $oldMember < $member');
				//                                        $credit=$member-$oldMember;
				//                                        Deposit::credit($booking->transaction->user_id,$credit,'airlines|'.$booking->airlines_transaction_id.'|Credit Smart Cash '.
				//                                            $booking->airline->name." ".
				//                                            $booking->origin."-".
				//                                            $booking->destination." (".
				//                                            $booking->itineraries->first()->pnr.")");
				//                                    }
				//                                    if($oldMember>$member){
				//
				//                                        Log::info('Masuk ke $oldMember > $member');
				//                                        $debit=$oldMember-$member;
				//                                        Deposit::debit($booking->transaction->user_id,$debit,'airlines|'.$booking->airlines_transaction_id.'|Credit Smart Cash '.
				//                                            $booking->airline->name." ".
				//                                            $booking->origin."-".
				//                                            $booking->destination." (".
				//                                            $booking->itineraries->first()->pnr.")");
				//                                    }
				//                                }
				//                            }else{
				//                                Log::info('tidak masuk ke sleksi pertama');
				//                                $booking->status='issued';
				//                                $booking->save();
				//                            }
				//                        }else{
				//                            $oldPaxpaid=$booking->paxpaid;
				//                            $oldNRA=$booking->nra;
				//                            $booking->status='issued';
				//                            $booking->paxpaid=floatval($status['harga']['paxpaid_ret']);
				//                            $booking->nra=floor($status['harga']['komisi_ret']);
				//                            $booking->nta=ceil($status['harga']['nta_ret']);
				//                            $booking->save();
				//                            foreach ($booking->itineraries as $itinerary){
				//                                $itinerary->pnr=$status['schedule']['return']['pnr'];
				//                                $itinerary->save();
				//                            }
				//                            $percentPusat=$booking->transaction->user->type_user->pusat_airlines->commission;
				//                            $percentBv=$booking->transaction->user->type_user->bv_airlines->commission;
				//                            $percentMember=$booking->transaction->user->type_user->member_airlines->commission;
				//                            $nra = intval($status['harga']['komisi_ret']);
				//                            $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
				//                            $free = intval($nra)-intval($komisi);
				//                            $pusat = intval(($komisi * $percentPusat)/100);
				//                            $bv = intval(($komisi * $percentBv)/100);
				//                            $member= intval(($komisi * $percentMember)/100);
				//                            $oldMember=$booking->transaction_commission->member;
				//                            $booking->transaction_commission->nra=$nra;
				//                            $booking->transaction_commission->komisi=$komisi;
				//                            $booking->transaction_commission->free=$free;
				//                            $booking->transaction_commission->pusat=$pusat;
				//                            $booking->transaction_commission->bv=$bv;
				//                            $booking->transaction_commission->member=$member;
				//                            $booking->transaction_commission->save();
				//                            Log::info('Selesai update NRA dan commission');
				//                            Log::info('$oldMEmber = '.$oldMember.', $member = '.$member);
				//                            Log::info('Masuk ke $oldMember < $member');
				//                            $credit=$member;
				//                            if((int)$oldPaxpaid>(int)$status['harga']['paxpaid_ret']){
				//                                Deposit::credit($booking->transaction->user_id,(int)$oldPaxpaid-(int)$status['harga']['paxpaid_ret']-(int)$oldMember,'airlines|'.$booking->airlines_transaction_id.'|Kredit selisih harga '.
				//                                    $booking->airline->name." ".
				//                                    $booking->origin."-".
				//                                    $booking->destination." (".
				//                                    $booking->itineraries->first()->pnr.")");
				//                            }
				//                            Deposit::credit($booking->transaction->user_id,$credit,'airlines|'.$booking->airlines_transaction_id.'|Credit Smart Cash '.
				//                                $booking->airline->name." ".
				//                                $booking->origin."-".
				//                                $booking->destination." (".
				//                                $booking->itineraries->first()->pnr.")");
				//                            if($oldPaxpaid!=floatval($status['harga']['paxpaid_ret'])||$oldNRA!=floatval($status['harga']['komisi_ret'])){
				//                                $booking->status='issued';
				//                                $booking->paxpaid=floatval($status['harga']['paxpaid_ret']);
				//                                $booking->nra=floor($status['harga']['komisi_ret']);
				//                                $booking->nta=ceil($status['harga']['nta_ret']);
				//                                $booking->save();
				//                                foreach ($booking->itineraries as $itinerary){
				//                                    $itinerary->pnr=$status['return']['pnr'];
				//                                    $itinerary->save();
				//                                }
				//                                if($oldNRA!=floatval($status['harga']['komisi_ret'])){
				//                                    $percentPusat=$booking->transaction->user->type_user->pusat_airlines->commission;
				//                                    $percentBv=$booking->transaction->user->type_user->bv_airlines->commission;
				//                                    $percentMember=$booking->transaction->user->type_user->member_airlines->commission;
				//                                    $nra = intval($status['harga']['komisi_ret']);
				//                                    $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
				//                                    $free = intval($nra)-intval($komisi);
				//                                    $pusat = intval(($komisi * $percentPusat)/100);
				//                                    $bv = intval(($komisi * $percentBv)/100);
				//                                    $member= intval(($komisi * $percentMember)/100);
				//                                    $oldMember=$booking->transaction_commission->member;
				//                                    $booking->transaction_commission->nra=$nra;
				//                                    $booking->transaction_commission->komisi=$komisi;
				//                                    $booking->transaction_commission->free=$free;
				//                                    $booking->transaction_commission->pusat=$pusat;
				//                                    $booking->transaction_commission->bv=$bv;
				//                                    $booking->transaction_commission->member=$member;
				//                                    $booking->transaction_commission->save();
				//                                    Log::info('Selesai update NRA dan commission');
				//                                    Log::info('$oldMEmber = '.$oldMember.', $member = '.$member);
				//                                    if($oldMember<$member){
				//                                        Log::info('Masuk ke $oldMember < $member');
				//                                        $credit=$member-$oldMember;
				//                                        Deposit::credit($booking->transaction->user_id,$credit,'airlines|'.$booking->airlines_transaction_id.'|Credit Smart Cash '.
				//                                            $booking->airline->name." ".
				//                                            $booking->origin."-".
				//                                            $booking->destination." (".
				//                                            $booking->itineraries->first()->pnr.")");
				//                                    }
				//                                    if($oldMember>$member){
				//                                        Log::info('Masuk ke $oldMember > $member');
				//                                        $debit=$oldMember-$member;
				//                                        Deposit::debit($booking->transaction->user_id,$debit,'airlines|'.$booking->airlines_transaction_id.'|Credit Smart Cash '.
				//                                            $booking->airline->name." ".
				//                                            $booking->origin."-".
				//                                            $booking->destination." (".
				//                                            $booking->itineraries->first()->pnr.")");
				//                                    }
				//                                }
				//                            }else{
				//                                $booking->status='issued';
				//                                $booking->save();
				//                            }
				//                        }
				//                        $messages[]="Success change status to issued ".$booking->airline->name." ".
				//                            $booking->origin."-".
				//                            $booking->destination." (".
				//                            $booking->itineraries->first()->pnr.")";
				//                    }else{
				//                        $messages[]='Didn\'t change anything'.$booking->origin."-".
				//                            $booking->destination." (".
				//                            $booking->itineraries->first()->pnr.")";
				//                    }
				//                }else{
				//                    $messages[]='Didn\'t anything'.$booking->origin."-".
				//                        $booking->destination." (".
				//                        $booking->itineraries->first()->pnr."). Error : error_msg: ".$status['error_msg'];
			}
//            }
		}
		$log = '';
		foreach ($messages as $mess) {
			$log .= $mess . '|';
		}
		if ($log != '') {
			LogCron::create(['log' => $log, 'service' => 'Airlines']);
		}
		return $messages;
	}
}
