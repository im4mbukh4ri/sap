<?php

use Illuminate\Database\Seeder;

class PulsaCommission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $services=\App\PpobService::where('parent_id',1)->get();
        foreach ($services as $service){
            foreach ($service->childs as $child){
                $child->pulsa_price()->sync([1]);
            }
        }
    }
}
