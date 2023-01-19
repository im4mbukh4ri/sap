<?php

use Illuminate\Database\Seeder;

class AirlineCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = App\AirlinesBooking::whereBetween('created_at', ['2018-09-12 00:00:00', '2018-09-12 23:59:59'])->where('status', '!=', 'failed')
        ->where('status', '!=', 'canceled')->get();

        foreach ( $bookings as $key => $booking) {
          $user = $booking->transaction->user;
          if ($user->role!='free') {
              $percentPusat=$user->type_user->pusat_airlines->commission;
              $percentBv=$user->type_user->bv_airlines->commission;
              $percentMember=$user->type_user->member_airlines->commission;
              $nra = $booking->nra;
              $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
              $free = intval($nra)-intval($komisi);
              $pusat = intval(($komisi * $percentPusat)/100);
              $bv = intval(($komisi * $percentBv)/100);
              $member= intval(($komisi * $percentMember)/100);
              $upline=0;
          } else {
              $percentPusat=$user->parent->type_user->pusat_airlines->commission;
              $percentBv=$user->parent->type_user->bv_airlines->commission;
              $percentMember=$user->parent->type_user->member_airlines->commission;
              $nra = $booking->nra;
              $komisi = floor(intval($nra)*intval(config('sip-config')['member_commission'])/100);
              $free = intval($nra)-intval($komisi);
              $pusat = intval(($komisi * $percentPusat)/100);
              $bv = intval(($komisi * $percentBv)/100);
              $member= intval(($komisi * $percentMember)/100);
              $comFree = ($member * $user->type_user->member_airlines->commission)/100;
              $comSIP = ($member * $user->type_user->pusat_airlines->commission)/100;
              $pusat = $pusat + $comSIP;
              $upline = $member - $comFree - $comSIP;
              $member = $comFree;
          }
          $booking->transaction_commission()->save(new \App\AirlinesCommission([
              'nra'=>$nra,
              'komisi'=>$komisi,
              'free'=>floor($free),
              'pusat'=>ceil($pusat),
              'bv'=>floor($bv),
              'member'=>floor($member),
              'upline'=>floor($upline)
          ]));
        }
    }
}
