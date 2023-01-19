<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 26/10/16
 * Time: 16:40
 */

namespace App\Helpers\API;


use App\Log;

abstract class Api
{
    protected $parameters;
    protected $data;
    protected $endPointAPI;
    protected $overWriteOptions=[];
    protected $url;

    public function __construct()
    {
        $this->url=config('sip-config')['api_url'];
    }

    public function all(){
        return $this->GetData()->data;
    }

    public function find($id){
        $this->parameters = "?id=".$id;
        return $this->GetData()->data;
    }

    public function search($column, $searchKey){
        $data = ( empty($this->data) ) ? $this->GetData()->data : $this->data;

        $rowColumn = array_column($data, $column);
        $s = preg_quote(ucwords($searchKey), '~');
        $res = preg_grep('~' . $s . '~', $rowColumn);
        $resKey = array_keys($res);
        $temp = [];
        foreach($data as $key => $val){
            if(in_array($key, $resKey)){
                array_push($temp, $val);
            }
        }
    }


    public function get(){
        return $this->data;
    }
    protected function getData(){
//        $this->parameters['rqid'] = 'Sm4ajndIdanf2k274hKSNjshfjhqkej1nRT';
        $request = json_decode($this->parameters, true);
        $request['rqid'] = 'sSm4ajndIdanf2k274hKSNjshfjhqkej1nRTt';
        $log = Log::create([
            'request'=>json_encode($request),
            'url'=>$this->url.$this->endPointAPI
        ]);
        $curl = curl_init();

        $options = [
            CURLOPT_URL => $this->url.$this->endPointAPI,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            //CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
        ];

        foreach( $this->overWriteOptions as $key => $val){
            $options[$key] = $val;
        }

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $data = json_decode($response,true);

        if($err){
            //throw new Exception($err, 1);
            $log->response = 'error : '.$err;
            $log->save();
            $res=[
                "error_code"=>"001",
                "error_msg"=>"Timeout"
            ];
            $this->data= $res;
            return $this;
        }
        $log->response = $response;
        $log->save();
        $this->data = $data;
        return $this;
//        if($code != "000"){
//            throw new Exception($data['error_msg'], 1);
//        }else{
//            $this->data = $data;
//            return $this;
//        }
    }
}
