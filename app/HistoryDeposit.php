<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryDeposit extends Model
{
    //
    protected $fillable=['user_id','deposit','debit','credit','note'];

    protected $hidden=['user_id'];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
