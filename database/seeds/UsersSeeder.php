<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $address=\App\Address::create([
            'detail'=>'Jl. Jakarta No. 68',
            'subdistrict_id'=>'1020',
            'phone'=>'0219384756'
        ]);
        $address->user()->save(new \App\User([
            'username'=>'dhaniemubarak',
            'name'=>'Mochamad Ramdhanie Mubarak',
            'email'=>'dhaniemubarak@gmail.com',
            'password'=>bcrypt('secret'),
            'role'=>'admin',
            'gender'=>'L',
            'birth_date'=>'1993-03-04',
            'actived'=>1,
            'type_user_id'=>1
        ]));
        $address->user()->save(new \App\User([
            'username'=>'member_silver',
            'name'=>'Member Silver',
            'email'=>'silver@sip.com',
            'password'=>bcrypt('secret'),
            'role'=>'silver',
            'gender'=>'L',
            'birth_date'=>'1993-03-04',
            'actived'=>1,
            'type_user_id'=>2
        ]));
        $address->user()->save(new \App\User([
            'username'=>'member_gold',
            'name'=>'Member Gold',
            'email'=>'gold@sip.com',
            'password'=>bcrypt('secret'),
            'role'=>'gold',
            'gender'=>'L',
            'birth_date'=>'1993-03-04',
            'actived'=>1,
            'type_user_id'=>3
        ]));
        $address->user()->save(new \App\User([
            'username'=>'member_platinum',
            'name'=>'Member Platinum',
            'email'=>'platinum@sip.com',
            'password'=>bcrypt('secret'),
            'role'=>'platinum',
            'gender'=>'L',
            'birth_date'=>'1993-03-04',
            'actived'=>1,
            'type_user_id'=>4
        ]));
        $address->user()->save(new \App\User([
            'username'=>'member_free',
            'name'=>'Member Free',
            'email'=>'free@sip.com',
            'password'=>bcrypt('secret'),
            'role'=>'silver',
            'gender'=>'L',
            'birth_date'=>'1993-03-04',
            'actived'=>1,
            'type_user_id'=>5
        ]));
    }
}
