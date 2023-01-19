<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobPhone extends Model
{
    //
    protected $fillable=['ppob_transaction_id','customer_name','period','nominal','admin','ref'];

    public function transaction(){
        return $this->belongsTo('App\PpobTransaction');
    }
}
