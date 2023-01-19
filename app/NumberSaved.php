<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumberSaved extends Model
{
  use SoftDeletes;
  
    protected $fillable=['id','user_id','service','ppob_service_id','name','number'];
    protected $hidden=['user_id','ppob_service','autodebit'];
    protected $appends=['service_name','product','autodebit_status','code'];
    public $incrementing=false;
    public function user(){
      return $this->belongsTo('App\User');
    }
    public function ppob_service(){
      return $this->belongsTo('App\PpobService','ppob_service_id');
    }
    public function autodebit(){
      return $this->hasOne('App\Autodebit','number_save_id');
    }
    public function getServiceNameAttribute(){
      if($this->ppob_service->parent){
        return $this->ppob_service->parent->name;
      }
      return $this->ppob_service->name;
    }
    public function getProductAttribute(){
      return $this->ppob_service->name;
    }
    public function getAutodebitStatusAttribute(){
      if($this->autodebit){
        return 1;
      }
      return 0;
    }
    public function getCodeAttribute(){
      return $this->ppob_service->code;
    }
}
