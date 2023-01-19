<?php

use Illuminate\Database\Seeder;

class PpobServiceSetPrice extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // idr commission 1
        // idr markup 6
        // idr price
        //
        $ppobServices = \App\PpobService::whereBetween('id', [361, 652])->get();
        foreach ($ppobServices as $ppobService) {
            if (!$ppobService->pulsa_commission->first()) {
                //idr commission 1
                $ppobService->pulsa_commission()->sync([1]);
            }
            if (!$ppobService->pulsa_markup->first()) {
                // idr markup 6
                $ppobService->pulsa_markup()->sync([6]);
            }

            if (!$ppobService->pulsa_bv_markup->first()) {
                // idr bv markup 6
                $ppobService->pulsa_bv_markup()->sync([6]);
            }

            if (!$ppobService->pulsa_price->first()) {
                //idr price 236
                $ppobService->pulsa_price()->sync([236]);
            }
        }
    }
}
