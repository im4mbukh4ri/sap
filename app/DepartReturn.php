<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartReturn extends Model
{
    //
    protected $table='depart_return';
    protected $fillable=['id','name'];
    public $timestamps=false;
}
