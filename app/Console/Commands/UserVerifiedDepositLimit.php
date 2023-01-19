<?php

namespace App\Console\Commands;

use App\Helpers\Deposit\Deposit;
use App\User;
use App\UserDepositDebit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UserVerifiedDepositLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:user_verified_deposit_debit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User verified deposit debit limit';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('role', '!=', 'admin')->where('deposit', '>', 10000000)->whereNotNull('verified_at')->get();
//        $users = User::where('deposit', '>', 10000000)->where('username', '=', 'member_platinum')->whereNotNull('verified_at')->get();
        foreach ($users as $user) {
            $deposit = (float)$user->deposit;
            $amount = (float)$deposit - 10000000;
            DB::beginTransaction();
            try {
                $debit = Deposit::debit($user->id, (float)$amount, 'debit|' . $user->id . "|Debit limit deposit")->get();
                if ($debit['status']['code'] == 200) {
                    $userDepositDebit = new UserDepositDebit;
                    $userDepositDebit->username = $user->username;
                    $userDepositDebit->phone_number = $user->phone_number;
                    $userDepositDebit->deposit = $deposit;
                    $userDepositDebit->debit = $amount;
                    $userDepositDebit->is_verified = 1;
                    $userDepositDebit->is_debit = 1;
                    $userDepositDebit->save();
                } else {
                    $userDepositDebit = new UserDepositDebit;
                    $userDepositDebit->username = $user->username;
                    $userDepositDebit->phone_number = $user->phone_number;
                    $userDepositDebit->deposit = $deposit;
                    $userDepositDebit->debit = $amount;
                    $userDepositDebit->is_verified = 1;
                    $userDepositDebit->is_debit = 0;
                    $userDepositDebit->save();
                }
            } catch (\Exception $e) {
                DB::rollback();
            }
            DB::commit();
        }
        return;
    }
}
