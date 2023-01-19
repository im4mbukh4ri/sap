<?php

namespace App\Helpers\CollectTransaction;

class CollectDataTransaction{
    protected $parameters;
    protected $data;
    protected $url;
    protected $overWriteOptions=[];

    public function __construct()
    {
        $this->url=config('sip-config')['collect_transaction_url'];
    }

    public function get(){
        return $this->data;
    }

    public function getData(){
        $curl = curl_init();

        $options = [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ];
        foreach( $this->overWriteOptions as $key => $val){
            $options[$key] = $val;
        }
        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $data = json_decode($response,true);
        $this->data = $data;
        return $this;

    }
}