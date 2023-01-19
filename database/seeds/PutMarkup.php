<?php

use Illuminate\Database\Seeder;

class PutMarkup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start="2017-05-01";
        $end="2017-05-31";
        $transactions = \App\PpobTransaction::where('service',1)
          ->whereBetween('created_at',[$start.' 00:00:00',$end.' 23:59:59'])->get();

        foreach ($transactions as $key => $transaction) {
          if($transaction->user->role === 'free'){
            $transaction->markup = $transaction->ppob_service->pulsa_markup->first()->markup;
            $transaction->save();
          }
        }
    }
}
