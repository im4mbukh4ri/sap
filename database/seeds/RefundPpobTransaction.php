<?php

use Illuminate\Database\Seeder;
use App\PpobFailedRefund;
use App\HistoryDeposit;
use App\Helpers\Deposit\Deposit;
use Illuminate\Support\Facades\Log;
class RefundPpobTransaction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $refunds = PpobFailedRefund::where('is_credit', '=', 0)->get();
        $statuses = [];
        foreach ($refunds as $i => $refund) {
          $transaction = $refund->ppob_transaction;
          $user = $transaction->user;
          $debit = HistoryDeposit::where('user_id', '=', $user->id)
            ->whereBetween('created_at', ['2018-09-01 00:00:00', '2018-09-01 23:59:59'])
            ->where('credit', '=', 0)->where('note', 'LIKE', 'ppob|'.$refund->ppob_transaction_id.'%')->first();
          if($debit) {
            Log::info('debit found');
            $note = explode('|', $debit->note);
            $credit = Deposit::credit($user->id,$debit->debit, 'ppob|'.$note[1].'|Refund '.$note[2])->get();
            if ($credit['status']['code'] == 200) {
              Log::info('Credit success');
              $refund->is_credit = 1;
              $refund->save();
              $statuses[$i] = [
                'user_id' => $user->id,
                'ppob_transaction_id' =>  $refund->ppob_transaction_id,
                'credit' => $debit->debit,
                'status' => 'SUCCESS CREDIT'
              ];
            } else {
              $statuses[$i] = [
                'user_id' => $user->id,
                'ppob_transaction_id' =>  $refund->ppob_transaction_id,
                'credit' => $debit->debit,
                'status' => 'FAILED CREDIT'
              ];
            }
          }else{
            $statuses[$i] = [
              'user_id' => $user->id,
              'ppob_transaction_id' =>  $refund->ppob_transaction_id,
              'credit' => 0,
              'status' => 'NOT FOUND'
            ];
          }
        }
        Log::info('Log status', ['status'=>$statuses]);
        return $statuses;
    }
}
