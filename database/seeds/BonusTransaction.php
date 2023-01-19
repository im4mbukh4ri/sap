<?php

use Illuminate\Database\Seeder;

class BonusTransaction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = \App\BonusTransaction::where('is_credit', 0)->get();

        foreach ($members as $key => $member) {
            $user = \App\User::where('username', $member->username)->first();
            if ($user) {
                DB::beginTransaction();
                try {
                    $credit = \App\Deposit::create([
                        'user_id' => $user->id,
                        'user_deposit' => $user->deposit,
                        'debit' => 0,
                        'credit' => $member->amount,
                        'note' => 'Penambahan deposit IDR ' . number_format($member->amount) . '. . Bonus Point Reward',
                        'created_by' => 1,
                    ]);
                    $result = \App\Helpers\Deposit\Deposit::credit($user->id, $member->amount, 'credit|' . $credit->id . '|Penambahan deposit IDR ' . number_format($member->amount) . '. Bonus Point Reward')->get();
                    if ($result['status']['code'] == 400) {
                        DB::rollback();
                        Log::info('failed credit deposit, username :'.$user->username.'. error : ' . $e->getMessage());
                        continue;
                    }
                    $member->is_credit = 1;
                    $member->save();
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::info('failed credit deposit, username :'.$user->username.'. error : ' . $e->getMessage());
                    continue;
                }
                DB::commit();
                sleep(0.2);
            }
        }
    }
}
