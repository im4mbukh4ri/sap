<?php

namespace App\Helpers\Services;


use App\AirlinesCode;
use App\PpobService;

class StatusProducts
{
    private $status;
    private $data;
    private $airlinesStatus;
    private $ppobStatus;

    public function __construct()
    {
        $this->setAirlinesStatus();
        $this->setPpobStatus();
        $this->setData();
    }

    public function get(){
        return $this->data;
    }
    public function setAirlinesStatus(){
        $airlines = AirlinesCode::where('is_domestic', '=', 1)->get();
        $collectData = array();
        foreach ($airlines as $airline){
            $status=($airline->status==1)?'OPEN':'CLOSE';
            $collectData[]=[
                'product'=>$airline->code,
                'status'=>$status
            ];
        }
        return $this->airlinesStatus = $collectData;
    }
    public function getAirlinesStatus(){
        return $this->airlinesStatus;
    }
    public function setPpobStatus(){
        $ppobs=PpobService::where('parent_id','0')->get();
        $collectData=array();
        foreach ($ppobs as $ppob){
            $status=($ppob->status==1)?'OPEN':'CLOSE';
            $collectData[]=[
                'product'=>$ppob->code,
                'status'=>$status
            ];
        }
        return $this->ppobStatus=$collectData;
    }
    public function getPpobStatus(){
        return $this->ppobStatus;
    }
    public function setData(){
        $data = [
            'AIRLINES'=>$this->getAirlinesStatus(),
            'AIRLINES INTERNATIONAL' => 'OPEN',
            'PPOB'=>$this->getPpobStatus(),
            'KAI'=>'OPEN',
            'RAILINK' => 'CLOSE',
            'BUS'=>'CLOSE',
            'HOTEL'=>'OPEN'
        ];
        $this->data=$data;
    }

}