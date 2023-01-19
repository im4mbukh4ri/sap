<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RailinkBooking extends Model
{
  protected $fillable=['train_transaction_id','depart_return_id','origin','destination',
    'train_name','train_number','class','subclass','etd','eta','paxpaid','nta','nra','pr','status','pnr'];
  public function depart_return(){
    return $this->belongsTo('App\DepartReturn');
  }
  public function destination_station(){
    return $this->belongsTo('App\RailinkStation','destination');
  }
  public function origin_station(){
    return $this->belongsTo('App\RailinkStation','origin');
  }
  public function transaction(){
    return $this->belongsTo('App\TrainTransaction','train_transaction_id');
  }
  public function failed_message(){
    return $this->hasOne('App\TransactionBookingFailedMessage');
  }
  public function transaction_number(){
    return $this->hasOne('App\RailinkBookingTransactionNumber');
  }
  public function commission(){
    return $this->hasOne('App\RailinkCommission');
  }
}
