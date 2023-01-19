<?php

use Illuminate\Database\Seeder;

class FlightTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\FlightType::create([
            'id'=>'O',
            'name'=>'One Way'
        ]);
        \App\FlightType::create([
            'id'=>'R',
            'name'=>'Return'
        ]);
    }
}
