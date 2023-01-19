<?php

namespace App\Console\Commands;

use App\Helpers\Deposit\Deposit;
use App\User;
use App\UserDepositDebit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class UserUnverifiedDepositLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:user_unverified_deposit_debit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User unverified deposit debit limit';

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
        $users = User::where('role', '!=', 'admin')->where('deposit', '>', 2000000)->whereNull('verified_at')->get();
//        $users = User::where('deposit', '>', 2000000)->where('username', '=', 'member_gold')->whereNull('verified_at')->get();

        foreach ($users as $user) {
            $deposit = (float)$user->deposit;
            $amount = (float)$deposit - 2000000;
            DB::beginTransaction();
            try {
                $debit = Deposit::debit($user->id, (float)$amount, 'debit|' . $user->id . "|Debit limit deposit")->get();
                if ($debit['status']['code'] == 200) {
                    $userDepositDebit = new UserDepositDebit;
                    $userDepositDebit->username = $user->username;
                    $userDepositDebit->phone_number = $user->phone_number;
                    $userDepositDebit->deposit = $deposit;
                    $userDepositDebit->debit = $amount;
                    $userDepositDebit->is_verified = 0;
                    $userDepositDebit->is_debit = 1;
                    $userDepositDebit->save();
                } else {
                    $userDepositDebit = new UserDepositDebit;
                    $userDepositDebit->username = $user->username;
                    $userDepositDebit->phone_number = $user->phone_number;
                    $userDepositDebit->deposit = $deposit;
                    $userDepositDebit->debit = $amount;
                    $userDepositDebit->is_verified = 0;
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
