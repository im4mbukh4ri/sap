<?php
/**
 * Created by Mochamad Ramdhanie Mubarak.
 * User: dhaniemubarak
 * Date: 23/03/2017
 * Time: 23:41
 */
namespace App\Helpers\Point;

use App\HistoryPoint;
use App\User;

abstract class PointService{
    protected $totalPoint;
    protected $point;
    protected $response;
    protected $endPoint;
    protected $user;

    public function __construct($userId)
    {
        $this->user = User::find($userId);
    }

    public function check(){
        $pointUser=$this->balance();
        $total=floatval($this->totalPoint);
        if($pointUser<$total){
            $this->response=false;
        }else{
            $this->response=true;
        }
    }
    public function balance(){
        $this->point=$this->user->point;
        return $this->response=$this->point;
    }
    public function debitPoint($transactionId){
        $this->check();
        if ($this->get()){
            $this->user->point=$this->point-$this->totalPoint;
            $this->user->save();
            $this->user->history_points()->save($history = new HistoryPoint([
                'point'=>$this->point,
                'debit'=>$this->totalPoint,
                'credit'=>0,
                'note'=>$transactionId
            ]));
            return $this->response =[
                'status'=>[
                    'code'=>200,
                    'message'=>'Success debit point : '.$this->totalPoint.' point'
                ],
                'response'=>[
                    'detail'=>$history
                ]
            ];
        }
        return $this->response =[
            'status'=>[
                'code'=>400,
                'message'=>'Your point not enough. Deposit : '.$this->point.' point'
            ]
        ];
    }
    public function creditPoint($transactionId){
        $this->check();
        $this->user->point=$this->point+$this->totalPoint;
        $this->user->save();
        $this->user->history_points()->save($history = new HistoryPoint([
            'point'=>$this->point,
            'debit'=>0,
            'credit'=>$this->totalPoint,
            'note'=>$transactionId
        ]));
        return $this->response =[
            'status'=>[
                'code'=>200,
                'message'=>'Success debit point : '.$this->totalPoint.' point'
            ],
            'response'=>[
                'detail'=>$history
            ]
        ];
    }
    public function get(){
        return $this->response;
    }

}