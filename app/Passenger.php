<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    //
    protected $fillable=['airlines_transaction_id','type','title','first_name','last_name','birth_date','national', 'departure_ticket_number',
        'return_ticket_number'];
    protected $hidden=['created_at','updated_at','deleted_at'];

    public function type_passenger(){
        return $this->belongsTo('App\TypePassenger','type');
    }
    public function airline_transaction(){
        return $this->belongsTo('App\AirlinesTransaction');
    }
    public function document_passenger(){
        return $this->hasOne('App\DocumentPassenger');
    }
    public function phone(){
        return $this->hasOne('App\PassengerPhone');
    }
}
