<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobPdam extends Model
{
    protected $table="ppob_pdam";
    protected $fillable=['ppob_transaction_id','customer_name','pdam_name','period','admin','nominal','ref'];

    public function transaction(){
        return $this->hasOne('App\PpobTransaction');
    }
    public function penalties(){
        return $this->hasMany('App\PpobPdamPenalty');
    }
}
