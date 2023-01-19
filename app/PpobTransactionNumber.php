<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobTransactionNumber extends Model
{
    //
    protected $fillable=['ppob_transaction_id','transaction_number'];

    public function ppob_transaction(){
        return $this->belongsTo('App\PpobTransaction');
    }
}
