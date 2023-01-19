<?php

use Illuminate\Database\Seeder;

class AirlinesTransactionCorrection extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = \App\AirlinesBooking::where('airlines_code','=', 'SJ')
            ->whereBetween('created_at', ['2019-01-08 00:00:00', '2019-01-08 09:10:00'])
            ->whereIn('status', ['booking', 'issued'])->where('nra', '=', 0)->get();
        foreach ($bookings as $booking){
            if ($booking->transaction->user->role != 'free') {
                $percentPusat = $booking->transaction->user->type_user->pusat_airlines->commission;
                $percentBv = $booking->transaction->user->type_user->bv_airlines->commission;
                $percentMember = $booking->transaction->user->type_user->member_airlines->commission;
                $nra = $booking->paxpaid * 0.015;
                $nta = $booking->paxpaid - $nra;
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
                $nra = $booking->paxpaid * 0.015;
                $nta = $booking->paxpaid - $nra;
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
            $booking->nta = $nta;
            $booking->nra = $nra;
            $booking->save();
            $booking->transaction_commission->nra = $nra;
            $booking->transaction_commission->komisi = $komisi;
            $booking->transaction_commission->free = $free;
            $booking->transaction_commission->pusat = $pusat;
            $booking->transaction_commission->bv = $bv;
            $booking->transaction_commission->member = $member;
            $booking->transaction_commission->upline = $upline;
            $booking->transaction_commission->save();


            if($booking->status == 'issued') {
                $note = "airlines|" . $booking->airlines_transaction_id . "|Credit Smart Cash " .
                    $booking->airline->name . " " .
                    $booking->origin . "-" .
                    $booking->destination . " (" .
                    $booking->itineraries->first()->pnr . ")";
                \App\Helpers\Deposit\Deposit::credit($booking->transaction->user_id, $member, $note)->get();
                if($upline > 0){
                    $note = "airlines|" . $booking->airlines_transaction_id . "|Credit Referral dari  " .$booking->transaction->user->name." ".
                        $booking->airline->name . " " .
                        $booking->origin . "-" .
                        $booking->destination . " (" .
                        $booking->itineraries->first()->pnr . ")";
                    \App\Helpers\Deposit\Deposit::credit($booking->transaction->user->upline, $upline, $note)->get();
                }
            }
        }
    }
}
