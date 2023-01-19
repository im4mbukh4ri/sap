<?php

use Illuminate\Database\Seeder;

class TypeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\TypeUser::create([
            'id'=>1,
           'name'=>'admin'
        ]);
        \App\TypeUser::create([
            'id'=>2,
            'name'=>'silver'
        ]);
        \App\TypeUser::create([
            'id'=>3,
            'name'=>'gold'
        ]);
        \App\TypeUser::create([
            'id'=>4,
            'name'=>'platinum'
        ]);
        \App\TypeUser::create([
            'id'=>5,
            'name'=>'free'
        ]);

    }
}
