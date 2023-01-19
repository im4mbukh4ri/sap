<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobPdamPenalty extends Model
{
    protected $table="ppob_pdam_penalty";
    protected $fillable=['ppob_transaction_id','month','first_meter_read','last_meter_read',
        'penalty','misc_amount'];
    public function pdam(){
        return $this->belongsTo('App\PpobPdam');
    }
}
