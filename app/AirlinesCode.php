<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirlinesCode extends Model
{
    //
    protected $fillable=['code','name','icon','status'];
    public $incrementing=false;
    public $timestamps=false;
    public $primaryKey='code';

}
