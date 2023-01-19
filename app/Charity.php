<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model {
	protected $fillable = ['title', 'content', 'url_image'];

	public function CharityTransaction() {
		return $this->belongsTo('App\CharityTransaction');
	}
}
