<?php

namespace App\Http\Controllers\Api;

use App\PpobTransaction;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use DB;

class DataTransactionsController extends Controller
{
    //
    public function index(Request $request,$service){
        $validator=Validator::make($request->all(),[
            'date'=>'required|date',
        ]);
        if($validator->fails()){
            return [
                'status'=>[
                    'code'=>400,
                    'confirm'=>'failed',
                    'message'=>$validator->errors()
                ]
            ];
        }

        switch ($service){
            case 'airlines':
                $data = $this->airlines($request);
                break;
            case 'pulsa':
                $data = $this->pulsa($request);
                break;
            case 'ppob':
                $data = $this->ppob($request);
                break;
            case 'train':
                $data = $this->train($request);
                break;
            case 'hotel':
                $data = $this->hotel($request);
                break;
            case 'prepaid':
                $data = $this->prepaid($request);
                break;
            case 'postpaid':
                $data = $this->postpaid($request);
                break;
            default:
                $data = Response::json([
                    'status'=>[
                        'code'=>400,
                        'confirm'=>"failed",
                        'message'=>['Periksa kembali url yang Anda masukan.']
                    ]
                ]);

        }
        return $data;
    }
    public function airlines($request){
        $datas = \App\AirlinesBooking::whereBetWeen('created_at', [$request->date . " 00:00:00", $request->date . " 23:59:59"])->where('status', 'issued')->get();

        $data = array();
        foreach ($datas as $val){
            $data[]=[
              'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
              'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
              'id_transaksi' => $val->airlines_transaction_id,
              'username' => $val->transaction->user->username,
              'produk' => 'airlines',
              'nama_produk' => $val->airlines_code . ' (' . $val->itineraries()->first()->pnr . ')',
              'market_price' => $val->paxpaid,
              'smart_value' => floor($val->nta),
              'point_reward' => $val->pr,
              'komisi' => ceil($val->nra),
              'komisi_90' => ceil($val->transaction_commission->komisi),
              'komisi_10' => floor($val->transaction_commission->free),
              'sip' => $val->transaction_commission->pusat,
              'smart_point' => $val->transaction_commission->bv,
              'smart_cash' => $val->transaction_commission->member,
              'smart_upline' => $val->transaction_commission->upline,
              'username_upline' => $val->transaction->user->parent->username,
            ];
        }
        return $this->success($data);
    }
    public function pulsa($request){

        // $datas = \App\PpobTransaction::whereBetWeen('created_at', [$request->date . " 00:00:00", $request->date . " 23:59:59"])->where('service', '=', 1)->where('status','SUCCESS')->get();
        // $data=array();
        $data = DB::table('ppob_transactions')
            ->join('users', 'users.id', '=', 'ppob_transactions.user_id')
            ->join('users AS upline', 'upline.upline', '=', 'upline.id')
            ->join('ppob_commissions', 'ppob_commissions.ppob_transaction_id', '=', 'ppob_transactions.id')
            ->join('ppob_services', 'ppob_services.id', '=', 'ppob_transactions.ppob_service_id')
            ->select(
              'ppob_transactions.id AS id_transaksi',
              'ppob_transactions.created_at AS created_at',
              'ppob_transactions.updated_at AS updated_at',
              'users.username AS username',
              'ppob_services.name AS nama_produk',
              'ppob_transactions.number AS number',
              'ppob_transactions.paxpaid AS market_price',
              'ppob_transactions.nta AS smart_value',
              'ppob_transactions.pr AS point_reward',
              'ppob_commissions.nra AS komisi',
              'ppob_commissions.komisi AS komisi_90',
              'ppob_commissions.free AS komisi_10',
              'ppob_commissions.pusat AS sip',
              'ppob_commissions.bv AS smart_point',
              'ppob_commissions.member AS smart_cash',
              'ppob_commissions.upline AS smart_upline',
              'upline.username AS username_upline'
            )->where('ppob_transactions.service', 1)->whereBetween('ppob_transactions.created_at', [$request->date . ' 00:00:00', $request->date . ' 23:59:59'])
            ->where('ppob_transactions.status', '=', 'SUCCESS')->get();
        // foreach ($datas as $val){
        //     $data[]=[
        //       'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
        //       'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
        //       'id_transaksi' => $val->id_transaction,
        //       'username' => $val->user->username,
        //       'produk' => 'pulsa',
        //       'nama_produk' => $val->ppob_service->name,
        //       'market_price' => $val->paxpaid,
        //       'smart_value' => floor($val->nta),
        //       'point_reward' => $val->pr,
        //       'komisi' => ceil($val->nra),
        //       'komisi_90' => ceil($val->transaction_commission->komisi),
        //       'komisi_10' => floor($val->transaction_commission->free),
        //       'sip' => $val->transaction_commission->pusat,
        //       'smart_point' => $val->transaction_commission->bv,
        //       'smart_cash' => $val->transaction_commission->member,
        //       'smart_upline' => $val->transaction_commission->upline,
        //       'username_upline' => $val->user->parent->username,
        //     ];
        // }
        return $this->success($data);
    }
    public function ppob(Request $request){
        $datas = PpobTransaction::whereBetWeen('created_at',[$request->date." 00:00:00",$request->date." 23:59:59"])->where('service','<>',1)->where('status','SUCCESS')->get();

        $data=array();
        foreach ($datas as $val){
            $data[]=[
              'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
              'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
              'id_transaksi' => $val->id_transaction,
              'username' => $val->user->username,
              'produk' => 'ppob',
              'nama_produk' => $val->ppob_service->name,
              'market_price' => $val->paxpaid,
              'smart_value' => floor($val->nta),
              'point_reward' => $val->pr,
              'komisi' => ceil($val->nra),
              'komisi_90' => ceil($val->transaction_commission->komisi),
              'komisi_10' => floor($val->transaction_commission->free),
              'sip' => $val->transaction_commission->pusat,
              'smart_point' => $val->transaction_commission->bv,
              'smart_cash' => $val->transaction_commission->member,
              'smart_upline' => $val->transaction_commission->upline,
              'username_upline' => $val->user->parent->username,
            ];
        }
        return $this->success($data);
    }

    public function hotel(Request $request){
      $datas = \App\HotelTransaction::whereBetween('created_at', [$request->date . " 00:00:00", $request->date . " 23:59:59"])->where('status', 'issued')->get();
      $data=array();
      foreach ($datas as $val){
          $data[]=[
              'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
              'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
              'id_transaksi' => $val->id,
              'username'=>$val->user->username,
              'produk' => 'hotel',
              'nama_produk' => 'Hotel',
              'market_price' => $val->total_fare,
              'smart_value' => floor($val->nta),
              'point_reward' => $val->pr,
              'komisi'=>ceil($val->nra),
              'komisi_90' => ceil($val->commission->komisi),
              'komisi_10' => floor($val->commission->free),
              'sip' => $val->commission->pusat,
              'smart_point' => $val->commission->bv,
              'smart_cash' => $val->commission->member,
              'smart_upline' => $val->commission->user_by_free_user,
              'username_upline' => $val->user->parent->username
          ];
      }
      return $this->success($data);
    }

    public function train($request) {
      $datas = \App\TrainBooking::whereBetWeen('created_at', [$request->date . " 00:00:00", $request->date . " 23:59:59"])->where('status', 'issued')->get();
      $data=array();
      foreach ($datas as $val){
          $data[]=[
            'created_at' => date("Y-m-d H:i:s", strtotime($val->created_at)),
            'updated_at' => date("Y-m-d H:i:s", strtotime($val->updated_at)),
            'id_transaksi' => $val->train_transaction_id,
            'username' => $val->transaction->user->username,
            'produk' => 'train',
            'nama_produk' => $val->train_name . ' ' . $val->class . ' (' . $val->pnr . ')',
            'market_price' => $val->paxpaid + $val->admin,
            'smart_value' => floor($val->nta),
            'point_reward' => $val->pr,
            'komisi' => ceil($val->nra),
            'komisi_90' => ceil($val->commission->komisi),
            'komisi_10' => floor($val->commission->free),
            'sip' => $val->commission->pusat,
            'smart_point' => $val->commission->bv,
            'smart_cash' => $val->commission->member,
            'smart_upline' => $val->commission->upline,
            'username_upline' => $val->transaction->user->parent->username,
          ];
      }
      return $this->success($data);
    }

    public function prepaid($request)
    {
        $data = DB::table('prepaid_transactions')
            ->join('users', 'users.id', '=', 'prepaid_transactions.user_id')
            ->join('users AS upline', 'upline.upline', '=', 'upline.id')
            ->join('prepaid_commissions', 'prepaid_commissions.prepaid_transaction_id', '=', 'prepaid_transactions.id')
            ->join('products', 'products.id', '=', 'prepaid_transactions.product_id')
            ->join('products as nominal', 'nominal.id', '=', 'prepaid_transactions.nominal_id')
            ->select(
                'prepaid_transactions.id AS id_transaksi',
                'prepaid_transactions.created_at AS created_at',
                'prepaid_transactions.updated_at AS updated_at',
                'users.username AS username',
                DB::raw('CONCAT(products.name, " ", nominal.name) AS nama_produk'),
                'prepaid_transactions.customer_number AS number',
                'prepaid_transactions.fare_amount AS market_price',
                'prepaid_transactions.nta_amount AS smart_value',
                'prepaid_commissions.nra AS komisi',
                'prepaid_commissions.komisi AS komisi_90',
                'prepaid_commissions.free AS komisi_10',
                DB::raw('(prepaid_commissions.pusat + prepaid_commissions.company_by_free_user) AS sip'),
                DB::raw('(prepaid_commissions.bv + prepaid_commissions.share_by_free_user + prepaid_transactions.markup_bv_amount) AS smart_point'),
                'prepaid_commissions.member AS smart_cash',
                'prepaid_commissions.user_by_free_user AS smart_upline',
                'upline.username AS username_upline'
            )->whereBetween('prepaid_transactions.created_at', [$request->date . ' 00:00:00', $request->date . ' 23:59:59'])
            ->where('prepaid_transactions.status', '=', 'SUCCESS')->get();
        return $this->success($data);
    }

    public function postpaid($request)
    {
        $data = DB::table('postpaid_transactions')
            ->join('users', 'users.id', '=', 'postpaid_transactions.user_id')
            ->join('users AS upline', 'upline.upline', '=', 'upline.id')
            ->join('postpaid_commissions', 'postpaid_commissions.postpaid_transaction_id', '=', 'postpaid_transactions.id')
            ->join('products', 'products.id', '=', 'postpaid_transactions.product_id')
            ->select(
                'postpaid_transactions.id AS id_transaksi',
                'postpaid_transactions.created_at AS created_at',
                'postpaid_transactions.updated_at AS updated_at',
                'users.username AS username',
                'products.name AS nama_produk',
                'postpaid_transactions.customer_number AS number',
                'postpaid_transactions.fare_amount AS market_price',
                'postpaid_transactions.nta_amount AS smart_value',
                'postpaid_commissions.nra AS komisi',
                'postpaid_commissions.komisi AS komisi_90',
                'postpaid_commissions.free AS komisi_10',
                DB::raw('(postpaid_commissions.pusat + postpaid_commissions.company_by_free_user) AS sip'),
                DB::raw('(postpaid_commissions.bv + postpaid_commissions.share_by_free_user) AS smart_point'),
                'postpaid_commissions.member AS smart_cash',
                'postpaid_commissions.user_by_free_user AS smart_upline',
                'upline.username AS username_upline'
            )->whereBetween('postpaid_transactions.created_at', [$request->date . ' 00:00:00', $request->date . ' 23:59:59'])
            ->where('postpaid_transactions.status', '=', 'SUCCESS')->get();
        return $this->success($data);
    }

    private function success($data){
        return Response::json([
            'status'=>[
                'code'=>200,
                'confirm'=>'success',
                'message'=>'Success get data'
            ],
            'details'=>[
                'data'=>$data
            ]
        ]);
    }
}
