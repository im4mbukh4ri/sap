<?php

use Illuminate\Database\Seeder;

class RevisionCommissionGaruda extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = [];
        $bookings = \App\AirlinesBooking::where('airlines_code', '=', 'GA')
            ->where('status', '=', 'issued')->whereBetween('created_at', ['2019-02-01 00:00;00', '2019-02-04 23:59:59'])->get();

        foreach ($bookings as $booking) {
            $notrx = $booking->transaction_number->transaction_number;

            $param = [
                'rqid' => 'Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT',
                'mmid' => 'mastersip',
                'app' => 'information',
                'action' => 'get_trx_detail',
                'notrx' => $notrx,
            ];
            $attributes = json_encode($param);

            $status = \App\Helpers\SipAirlines::GetSchedule($attributes, false)->get();
            if ($status['error_code'] == '000') {
                $booking->paxpaid = floatval($status['harga']['paxpaid']);
                $booking->nra = floor($status['harga']['komisi']);
                if (isset($status['harga']['nta'])) {
                    $booking->nta = ceil($status['harga']['nta']);
                } else {
                    $booking->nta = ceil($status['harga']['NTA']);
                }
                $booking->save();
                if ($booking->transaction->user->role != 'free') {
                    $percentPusat = $booking->transaction->user->type_user->pusat_airlines->commission;
                    $percentBv = $booking->transaction->user->type_user->bv_airlines->commission;
                    $percentMember = $booking->transaction->user->type_user->member_airlines->commission;
                    $nra = intval($status['harga']['komisi']);
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
                    $nra = intval($status['harga']['komisi']);
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
                $booking->transaction_commission->nra = $nra;
                $booking->transaction_commission->komisi = $komisi;
                $booking->transaction_commission->free = $free;
                $booking->transaction_commission->pusat = $pusat;
                $booking->transaction_commission->bv = $bv;
                $booking->transaction_commission->member = $member;
                $booking->transaction_commission->upline = $upline;
                $booking->transaction_commission->save();
                $credit = $member;
                $note = "airlines|" . $booking->airlines_transaction_id . "|Credit Smart Cash " .
                    $booking->airline->name . " " .
                    $booking->origin . "-" .
                    $booking->destination . " (" .
                    $booking->itineraries->first()->pnr . ")";
                \App\Helpers\Deposit\Deposit::credit($booking->transaction->user_id, $credit, $note)->get();
                if ($booking->transaction->user->role == 'free') {
                    $note = "airlines|" . $booking->airlines_transaction_id . "|Credit Referal dari " . $booking->transaction->user->name . ' ' .
                        $booking->airline->name . " " .
                        $booking->origin . "-" .
                        $booking->destination;
                    $checkRefund = \App\HistoryDeposit::where('user_id', '=', $booking->transaction->user->upline)->where('credit', '=', $upline)->where('note', '=', $note)->first();

                    if ($checkRefund) {
                        $messages[] = 'Failed credit '.$note.'. Has been credit';
                        continue;
                    }
                    \App\Helpers\Deposit\Deposit::credit($booking->transaction->user->upline, $upline, $note)->get();
                }
                $messages[] = "Success credit commission " . $booking->airline->name . " " .
                    $booking->origin . "-" .
                    $booking->destination . " (" .
                    $booking->itineraries->first()->pnr . ")";
            }
        }
        $log = '';
        foreach ($messages as $mess) {
            $log .= $mess . '|';
        }
        if ($log != '') {
            \App\LogCron::create(['log' => $log, 'service' => 'Airlines']);
        }
    }
}
