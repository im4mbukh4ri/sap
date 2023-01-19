<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelGuest extends Model {
	protected $fillable = ['hotel_transaction_id', 'name', 'type', 'phone', 'title'];
	public $timestamps = false;
	public function transaction() {
		return $this->belongsTo('App\HotelTransaction', 'hotel_transaction_id');
	}
}
