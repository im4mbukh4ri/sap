<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobCommission extends Model
{
    protected $fillable=['ppob_transaction_id','nra','komisi','free','','pusat','bv','member','upline'];
    protected $hidden=['id','ppob_transaction_id','created_at','updated_at'];
    public function ppob_transaction(){
        return $this->belongsTo('App\PpobTransaction');
    }
}
