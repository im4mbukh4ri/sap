<?php

namespace App\Console\Commands;

use App\MasterTransaction;
use App\MasterTransactionDetail;
use App\Payment;
use App\PostpaidCommission;
use App\PostpaidElectricity;
use App\PostpaidPdam;
use App\PostpaidTransaction;
use App\PpobTransaction;
use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PdamReplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:pdam_replication';

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

    protected $description = 'Replikasi PDAM';

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
        $transactions = PpobTransaction::where('service', '=', 8)
            ->where('status', '=', 'SUCCESS')
            ->where('on_check', '=', 0)
            ->orderBy('id', 'desc')->take(10)->get();

        foreach ($transactions as $pulsa) {
            $pulsa->on_check = 1;
            $pulsa->save();
        }

        foreach ($transactions as $pulsa) {
            sleep(2);
            $productCode = $pulsa->ppob_service->code;

            if (!$productCode || $productCode === '') {
                $pulsa->on_check = 2;
                $pulsa->save();
                continue;
            }

            if (!$pulsa->pdam) {
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

                $detail = new PostpaidPdam;
                $detail->customer_name = $pulsa->pdam->customer_name;
                $detail->period = $pulsa->pdam->period;
                $detail->bill_amount = $pulsa->pdam->nominal;
                $detail->admin_amount = $pulsa->pdam->admin;
                $detail->reference = $pulsa->pdam->ref;
                $detail->supplier_service_code = 'PAM';
                $detail->supplier_product_code = $productCode;
                $detail->supplier_transaction_id = $transactionNumber;
                $detail->created_at = $pulsa->created_at;
                $detail->save();


                $postpaid = new PostpaidTransaction;
                $postpaid->user_id = $pulsa->user_id;
                $postpaid->service_id = $product->parent_id;
                $postpaid->product_id = $product->id;
                $postpaid->customer_number = $pulsa->number;
                $postpaid->fare_amount = $pulsa->paxpaid;
                $postpaid->discount_amount = 0;
                $postpaid->nta_amount = $pulsa->nta;
                $postpaid->nra_amount = $pulsa->nra;
                $postpaid->admin_amount = $pulsa->pdam->admin;
                $postpaid->status = 'success';
                switch ($pulsa->device) {
                    case 'ios':
                        $postpaid->device = 'ios';
                        break;
                    case 'web':
                        $postpaid->device = 'web';
                        break;
                    case 'system':
                        $postpaid->device = 'system';
                        break;
                    default:
                        $postpaid->device = 'android';
                        break;
                }
                $postpaid->detailable_type = 'App\Models\Postpaid\PostpaidPdam';
                $postpaid->detailable_id = $detail->id;
                $postpaid->on_check = 1;
                $postpaid->created_at = $pulsa->created_at;
                $postpaid->updated_at = $pulsa->updated_at;
                $postpaid->save();

                $comm = new PostpaidCommission;
                $comm->postpaid_transaction_id = $postpaid->id;
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
                $masterTransactionDetails->product_id = 298;
                $masterTransactionDetails->transactionable_type = 'App\Models\Postpaid\PostpaidTransaction';
                $masterTransactionDetails->transactionable_id = $postpaid->id;
                $masterTransactionDetails->created_at = $pulsa->created_at;
                $masterTransactionDetails->save();
            } catch (\Exception $e) {
                print($e->getMessage());
                DB::rollback();
                $pulsa->on_check = 2;
                $pulsa->save();
                continue;
            }
            DB::commit();
        }
    }
}
