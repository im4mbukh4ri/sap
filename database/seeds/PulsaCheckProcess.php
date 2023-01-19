<?php

use Illuminate\Database\Seeder;

class PulsaCheckProcess extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $startTime = '2018-02-12 00:00:00';
        $endTime = '2018-02-12 23:59:59';

        $transactions = \App\PpobTransaction::where('service', '=', 1)
          ->whereBetween('created_at', [$startTime,$endTime])
          ->where('status', '=', 'PROCESS')->get();

        foreach ($transactions as $key => $transaction) {
            $service = \App\PpobTransaction::where('ppob_service_id', '=', $transaction->ppob_service_id)
            ->where('status', '=', 'SUCCESS')->orderBy('id', 'desc')->first();
            $nta = $service->nta;
            $nra = $service->nra;
            if ($transaction->user->role != 'free') {
                $markup = 0;
                $percentPusat = $transaction->user->type_user->pusat_ppob->commission;
                $percentBv = $transaction->user->type_user->bv_ppob->commission;
                $percentMember = $transaction->user->type_user->member_ppob->commission;
                $sip = ($nra * $percentPusat) / 100;
                $bv = ($nra * $percentBv) / 100;
                $commission= ((int) $nra * $percentMember) / 100;
                $upline = 0;
            } else {
                $markup = $transaction->ppob_service->pulsa_markup->first()->markup;
                $percentPusat = $transaction->user->parent->type_user->pusat_ppob->commission;
                $percentBv =  $transaction->user->parent->type_user->bv_ppob->commission;
                $percentMember =  $transaction->user->parent->type_user->member_ppob->commission;
                $sip = (($nra * $percentPusat) / 100) + $markup;
                $bv = ($nra * $percentBv) / 100;
                $scMember = ((int) $nra * $percentMember) / 100;
                $commission = $scMember * $transaction->user->type_user->member_ppob->commission / 100;
                $feeSIP = $scMember * $transaction->user->type_user->pusat_ppob->commission / 100;
                $upline = $scMember - $commission - $feeSIP;
                $sip = $sip + $feeSIP;
            }
            $transaction->transaction_commission()->create([
              'nra' => $nra,
              'komisi'=> $nra,
              'free' => 0,
              'pusat' => $sip,
              'bv' => $bv,
              'member' => $commission,
              'upline' => $upline
            ]);
            $transaction->transaction_number()->create([
              'transaction_number'=>''
            ]);
            $transaction->nta = $nta;
            $transaction->nra = $nra;
            $transaction->markup = $markup;
            $transaction->save();
        }
    }
}
