<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PpobTransaction extends Model {
	/*
		     * Primary key is BIGINT. 0 to 18446744073709551615.
	*/
	protected $fillable = ['id', 'id_transaction', 'user_id', 'service', 'ppob_service_id', 'number', 'qty', 'nta', 'nra', 'paxpaid', 'status', 'device', 'pr', 'markup'];
	protected $appends = ['product_name', 'commission'];
	protected $hidden = ['user_id', 'service', 'deleted_at', 'transaction_commission', 'ppob_service'];

	public function user() {
		return $this->belongsTo('App\User');
	}
	public function finance() {
		return $this->hasOne('App\PpobFinance');
	}
	public function bpjs() {
		return $this->hasOne('App\PpobBpjs');
	}
	public function pdam() {
		return $this->hasOne('App\PpobPdam');
	}
	public function pdam_penalties() {
		return $this->hasMany('App\PpobPdamPenalty');
	}
	public function phone() {
		return $this->hasOne('App\PpobPhone');
	}
	public function pln_pasca() {
		return $this->hasOne('App\PpobPlnPasca');
	}
	public function pln_pra() {
		return $this->hasOne('App\PpobPlnPra');
	}
	public function credit_card() {
		return $this->hasOne('App\PpobCreditCard');
	}
	public function transaction_number() {
		return $this->hasOne('App\PpobTransactionNumber');
	}
	public function transaction_commission() {
		return $this->hasOne('App\PpobCommission');
	}
	public function ppob_service() {
		return $this->belongsTo('App\PpobService', 'ppob_service_id');
	}
	public function tag_months() {
		return $this->hasMany('App\PpobTagMonth');
	}
	public function getCommissionAttribute() {
		if (isset($this->transaction_commission)) {
			return $this->transaction_commission;
		} else {
			return [
				'nra' => 0,
				'komisi' => 0,
				'free' => 0,
				'pusat' => 0,
				'bv' => 0,
				'member' => 0,

			];
		}

	}
	public function getProductNameAttribute() {
		return $this->ppob_service->name;
	}
	public function serial_number() {
		return $this->hasOne('App\PpobSerialNumber', 'ppob_transaction_id');
	}
}
