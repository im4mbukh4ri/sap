<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RailinkStation extends Model
{
  public $incrementing=false;
  public $timestamps=false;
  public $primaryKey='code';

  protected $fillable=['code','name','city'];
}
