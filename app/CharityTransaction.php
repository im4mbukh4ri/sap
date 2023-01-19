<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharityTransaction extends Model {
	protected $fillable = ['title', 'user_id', 'charity_id', 'nominal', 'status'];
	protected $appends = ['charity_name'];
	protected $hidden = ['charity'];
	public function charity() {
		return $this->belongsTo('App\Charity');
	}
	public function user() {
		return $this->belongsTo('App\User');
	}
	public function getCharityNameAttribute() {
		return $this->charity->title;
	}
}
