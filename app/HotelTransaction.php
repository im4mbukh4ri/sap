<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelTransaction extends Model {
	//
	public $incrementing = false;
	protected $fillable = ['id', 'user_id', 'hotel_id', 'checkin', 'checkout', 'adt',
		'chd', 'inf', 'room', 'total_fare', 'nta', 'nra', 'status', 'pr', 'device'];
	protected $appends = ['hotel_name'];
	public function hotel() {
		return $this->belongsTo('App\Hotel', 'hotel_id');
	}
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}
	public function hotel_rooms() {
		return $this->hasMany('App\HotelTransactionRoom', 'hotel_transaction_id');
	}
	public function hotel_guest() {
		return $this->hasOne('App\HotelGuest', 'hotel_transaction_id');
	}
	public function guest_note() {
		return $this->hasOne('App\HotelGuestNote', 'hotel_transaction_id');
	}
	public function getHotelNameAttribute() {
		return $this->hotel()->first()->name;
	}
	public function commission() {
		return $this->hasOne('App\HotelCommission', 'hotel_transaction_id');
	}
	public function voucher() {
		return $this->hasOne('App\HotelVoucher', 'hotel_transaction_id');
	}
}
