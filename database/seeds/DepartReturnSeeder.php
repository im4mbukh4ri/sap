<?php

use Illuminate\Database\Seeder;

class DepartReturnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\DepartReturn::create([
          'id'=>'d',
          'name'=>'Depart',
        ]);
        \App\DepartReturn::create([
          'id'=>'r',
          'name'=>'Return',
        ]);
    }
}
