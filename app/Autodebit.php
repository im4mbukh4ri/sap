<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autodebit extends Model
{
    protected $fillable=['id','user_id','number_save_id','date','status'];
    protected $hidden=['user_id','number_saved'];
    protected $appends=['name','service','product','number'];
    public $incrementing = false;

    public function user(){
      return $this->belongsTo('App\User');
    }
    public function number_saved(){
      return $this->belongsTo('App\NumberSaved','number_save_id');
    }
    public function getNameAttribute(){
      return $this->number_saved->name;
    }
    public function getServiceAttribute(){
      if($this->number_saved->ppob_service->parent_id!=0){
        return $this->number_saved->ppob_service->parent->name;
      }
      return $this->number_saved->ppob_service->name;
    }
    public function getProductAttribute(){
      return $this->number_saved->ppob_service->name;
    }
    public function getNumberAttribute(){
      return $this->number_saved->number;
    }

}
