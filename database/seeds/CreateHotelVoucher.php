<?php

use Illuminate\Database\Seeder;

class CreateHotelVoucher extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::where('role', '!=', 'admin')->where('role', '!=', 'free')->whereBetween('created_at', [
            '2020-02-15 00:00:00', '2020-02-27 23:59:59'
        ])->get();
        foreach ($users as $user) {
            if ($user->vouchers->count() === 0) {
                $quantity = 40;
                if ($user->role === 'advance') {
                    $quantity = 200;
                } elseif ($user->role === 'pro') {
                    $quantity = 500;
                }

                \App\UserVoucher::create([
                    'user_id' => $user->id,
                    'voucher_id' => 1,
                    'quantity' => $quantity
                ]);
            }
        }
    }
}
