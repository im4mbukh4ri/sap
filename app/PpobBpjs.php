<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobBpjs extends Model
{
    protected $table='ppob_bpjs';
    protected $fillable=['ppob_transaction_id','customer_name','kode_cabang','nama_cabang','admin','nominal','ref'];

    public function transaction(){
        $this->belongsTo('App\PpobTransaction');
    }
}
