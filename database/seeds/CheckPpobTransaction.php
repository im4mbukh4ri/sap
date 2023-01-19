<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CheckPpobTransaction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Log::info("Start");
        $transactions = \App\PpobTransaction::where('status','=','SUCCESS')->whereBetween('created_at',['2017-06-01 00:00:00','2017-06-30 23:59:59'])->get();
        foreach ($transactions as $key => $value) {
          //Log::info("Create data ke-".$key);
          $app=App\HistoryDeposit::where('note','LIKE','ppob|'.$value->id_transaction.'|%')->first();
          if(!$app){
            Log::info("LOST data id : ".$value->id);
            $value->status="LOST";
            $value->save();
          }
        }
    }
}
