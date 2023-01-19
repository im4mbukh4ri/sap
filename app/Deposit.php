<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model {
	//
	protected $fillable = ['user_id', 'user_deposit', 'debit', 'credit', 'note', 'created_by'];
	protected $appends = ['username'];
	protected $hidden = ['user_id', 'note', 'created_by', 'user', 'user_deposit'];

	public function user() {
		return $this->belongsTo('App\User');
	}
	// Tetap ada takut berpengaruh di dengan method2 yang lain
	public function created_by() {
		return $this->belongsTo('App\User', 'created_by');
	}

	public function admin() {
		return $this->belongsTo('App\User', 'created_by');
	}

	public function getUsernameAttribute() {
		return $this->user->username;
	}
}
