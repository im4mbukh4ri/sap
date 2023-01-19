<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPoint extends Model
{
    //
    protected $fillable=['user_id','point','debit','credit','note'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
