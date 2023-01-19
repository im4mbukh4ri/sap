<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobFinance extends Model
{
    //
    protected $fillable=['ppob_transaction_id','customer_name','tenor','period','no_polisi','nominal','admin','ref'];
    public function transaction(){
        return $this->belongsTo('App\PpobTransaction');
    }
}
