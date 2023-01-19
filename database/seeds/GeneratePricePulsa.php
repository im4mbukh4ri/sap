<?php

use Illuminate\Database\Seeder;

class GeneratePricePulsa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = \App\PpobTransaction::where('service','=',1)->where('device','=','ios')->get();
        foreach ($transactions as $key => $transaction) {
          $user=App\User::find($transaction->user_id);
          $product=\App\PpobService::find($transaction->ppob_service_id);
          $price=$product->pulsa_price->first()->price;
          if($user->role=="free"){
            $price+=$product->pulsa_markup->first()->markup;
          }
          $transaction->paxpaid=$price;
          $transaction->save();
        }
    }
}
