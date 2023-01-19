<?php

namespace App\Console\Commands;

use App\MasterTransaction;
use App\MasterTransactionDetail;
use App\Payment;
use App\PpobTransaction;
use App\PrepaidCommission;
use App\PrepaidPulsa;
use App\PrepaidTransaction;
use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PulsaReplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:pulsa_replication';

    /**
     * The console command description.
     *
     * @var string
     */
    /**
     * Params for send check status
     * @string rqid
     * @string mmid
     * @string app
     * @string action
     */
    private $rqid;
    private $mmid;
    private $action;
    private $app;

    protected $description = 'Replikasi pulsa';

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
     * @return void
     */
    public function handle()
    {
        $transactions = PpobTransaction::where('service', '=', 1)
            ->where('status', '=', 'success')
            ->where('on_check', '=', 0)
            ->orderBy('id', 'desc')->take(30)->get();

        foreach ($transactions as $pulsa) {
            $pulsa->on_check = 1;
            $pulsa->save();
        }

        foreach ($transactions as $pulsa) {
            sleep(1);
            $productCode = $pulsa->ppob_service->code;

            if (!$productCode || $productCode === '') {
                $pulsa->on_check = 2;
                $pulsa->save();
                continue;
            }

            $commission = $pulsa->transaction_commission;

            if (!$commission) {
                $pulsa->on_check = 2;
                $pulsa->save();
                continue;
            }

            $serialNumber = $pulsa->serial_number;
            if (!$serialNumber) {
                $pulsa->on_check = 2;
                $pulsa->save();
                continue;
            }
            $serialNumber = $serialNumber->serial_number;

            $transactionNumber = $pulsa->transaction_number;

            if (!$transactionNumber) {
                $pulsa->on_check = 2;
                $pulsa->save();
                continue;
            }
            $transactionNumber = $transactionNumber->transaction_number;

            // Cari product baru
            $product = Product::where('code', '=', $productCode)->first();

            if (!$product) {
                $pulsa->on_check = 2;
                $pulsa->save();
                Log::info("Product not found");
                continue;
            }

            DB::beginTransaction();
            try {
                $masterTransaction = new MasterTransaction;
                $masterTransaction->user_id = $pulsa->user_id;
                $masterTransaction->fare_amount = $pulsa->paxpaid;
                $masterTransaction->nta_amount = $pulsa->nta;
                $masterTransaction->discount_amount = 0;
                $masterTransaction->status = 'paid';
                $masterTransaction->expired_at = $pulsa->created_at;
                $masterTransaction->created_at = $pulsa->created_at;
                $masterTransaction->updated_at = $pulsa->updated_at;
                $masterTransaction->save();

                $payment = new Payment;
                $payment->payment_service_id = 'd_m';
                $payment->master_transaction_id = $masterTransaction->id;
                $payment->total_amount = $pulsa->paxpaid - $commission->member;
                $payment->discount_amount = 0;
                $payment->others = 0;
                $payment->unique_code = 0;
                $payment->is_split_bills = 0;
                $payment->deposit_nominal = $pulsa->paxpaid - $commission->member;;
                $payment->remaining_amount = 0;
                $payment->status = 'paid';
                $payment->verifiable_type = 'App\Models\User\User';
                $payment->verifiable_id = $pulsa->user_id;
                $payment->created_at = $pulsa->created_at;
                $payment->updated_at = $pulsa->updated_at;
                $payment->save();

                $detail = new PrepaidPulsa;
                $detail->serial_number = $serialNumber;
                $detail->supplier_transaction_id = $transactionNumber;
                $detail->supplier_service_code = 'PUL';
                $detail->supplier_product_code = $productCode;
                $detail->save();


                $prepaid = new PrepaidTransaction;
                $prepaid->user_id = $pulsa->user_id;
                $prepaid->service_id = $product->parent->parent_id;
                $prepaid->product_id = $product->parent->id;
                $prepaid->nominal_id = $product->id;
                $prepaid->customer_number = $pulsa->number;
                $prepaid->fare_amount = $pulsa->paxpaid;
                $prepaid->discount_amount = abs($pulsa->paxpaid - $pulsa->nta) + $pulsa->nra + $pulsa->bv_markup;
                $prepaid->markup_amount = $pulsa->markup;
                $prepaid->markup_bv_amount = $pulsa->bv_markup;
                $prepaid->nta_amount = $pulsa->nta;
                $prepaid->nra_amount = $pulsa->nra;
                $prepaid->status = 'success';
                switch ($pulsa->device) {
                    case 'ios':
                        $prepaid->device = 'ios';
                        break;
                    case 'web':
                        $prepaid->device = 'web';
                        break;
                    case 'system':
                        $prepaid->device = 'system';
                        break;
                    default:
                        $prepaid->device = 'android';
                        break;
                }
                $prepaid->detailable_type = 'App\Models\Prepaid\PrepaidPulsa';
                $prepaid->detailable_id = $detail->id;
                $prepaid->on_check = 1;
                $prepaid->created_at = $pulsa->created_at;
                $prepaid->updated_at = $pulsa->updated_at;
                $prepaid->save();

                $comm = new PrepaidCommission;
                $comm->prepaid_transaction_id = $prepaid->id;
                $comm->nra = $commission->nra;
                $comm->komisi = $commission->komisi;
                $comm->free = $commission->free;
                $comm->pusat = $commission->pusat;
                $comm->bv = $commission->bv;
                $comm->member = $commission->member;
                $comm->upline = $commission->upline;
                $comm->company_by_free_user = 0;
                $comm->share_by_free_user = 0;
                $comm->user_by_free_user = $commission->upline;
                $comm->created_at = $commission->created_at;
                $comm->updated_at = $commission->updated_at;
                $comm->save();

                $masterTransactionDetails = new MasterTransactionDetail;
                $masterTransactionDetails->master_transaction_id = $masterTransaction->id;
                $masterTransactionDetails->product_id = 30;
                $masterTransactionDetails->transactionable_type = 'App\Models\Prepaid\PrepaidTransaction';
                $masterTransactionDetails->transactionable_id = $prepaid->id;
                $masterTransactionDetails->save();

            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                $pulsa->on_check = 2;
                $pulsa->save();
                continue;
            }
            DB::commit();
        }
    }
}
