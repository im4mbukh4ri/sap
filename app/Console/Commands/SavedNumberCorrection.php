<?php

namespace App\Console\Commands;

use App\NumberSaved;
use App\PostpaidTransaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SavedNumberCorrection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:saved_number_correction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $limit = strtotime('2020-06-19 22:57:47');
        $numbers = NumberSaved::whereNull('product_code')->orderBy('created_at', 'desc')->take(58)->get();
        foreach ($numbers as $number) {
            sleep(1);
            $created = strtotime($number->created_at);
            if ($created > $limit) {
                $data = PostpaidTransaction::where('customer_number', '=', $number->number)->first();
                if ($data) {
                    $number->product_code = $data->product->code;
                    if ($number->service_code === null) {
                        if ($number->service === 2) {
                            $number->service_code = 'PLNPRA';
                        } elseif ($number->service === 3) {
                            $number->service_code = 'PLNPOST';
                        } else {
                            if ($number->ppob_service->parent) {
                                $number->service_code = $number->ppob_service->parent->code;
                            } else {
                                $number->service_code = $number->ppob_service->code;
                            }
                        }
                    }
                    $number->save();
                } else {
                    $number->delete();
                }
            } else {
                if ($number->service === 2) {
                    $number->service_code = 'PLNPRA';
                } elseif ($number->service === 3) {
                    $number->service_code = 'PLNPOST';
                } else {
                    if ($number->ppob_service->parent) {
                        $number->service_code = $number->ppob_service->parent->code;
                    } else {
                        $number->service_code = $number->ppob_service->code;
                    }
                }
                $number->product_code = $number->ppob_service->code;

                $number->save();
            }
        }
    }
}
