<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model {
	public $incrementing = false;

	protected $fillable = ['user_id', 'type_user_id', 'device', 'lat', 'lng', 'share_location', 'show_on_map'];

	public function user() {
		return $this->belongsTo('App\User');
	}
}
