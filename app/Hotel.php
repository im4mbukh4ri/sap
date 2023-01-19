<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
  protected $fillable = ['hotel_city_id','name','rating','address','email','website',
    'url_image'
  ];

  protected $table = 'hotels';

  public function rooms(){
    return $this->hasMany('App\HotelRoom');
  }
  public function hotel_city() {
    return $this->belongsTo('App\HotelCity','hotel_city_id');
  }

  public function getAddressAttribute()
  {
      return '';
  }
}
