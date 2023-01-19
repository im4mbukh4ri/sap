<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobPlnPasca extends Model
{
    //
    protected $table="ppob_pln_pasca";
    protected $fillable=['ppob_transaction_id','customer_name','golongan_daya','nominal','admin','stand_meter','period'];

    public function transaction(){
        return $this->belongsTo('App\PpobTransaction');
    }
}
