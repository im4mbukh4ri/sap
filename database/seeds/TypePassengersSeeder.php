<?php

use Illuminate\Database\Seeder;

class TypePassengersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\TypePassenger::create([
            'id'=>'adt',
            'type'=>'Adult',
        ]);
        \App\TypePassenger::create([
            'id'=>'chd',
            'type'=>'Child',
        ]);
        \App\TypePassenger::create([
            'id'=>'inf',
            'type'=>'Infant',
        ]);
    }
}
