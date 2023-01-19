<?php

use Illuminate\Database\Seeder;

class DeleteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::where('upline', 5159)->orderBy('id')->take(5000)->get();

        foreach ($users as $key => $user) {
            $travelAddressId = $user->travel_agent->address_id;
            $userAddressId = $user->address_id;
            $user->travel_agent()->delete();
            $user->referral()->delete();
            $user->delete();
            $travelAddress = \App\Address::find($travelAddressId);
            $travelAddress->delete();
            $userAddress = \App\Address::find($userAddressId);
            $userAddress->delete();
        }
    }
}
