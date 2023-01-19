<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContentViewer extends Model
{
    public $incrementing = false;
    protected $fillable = ['user_id', 'content_type', 'content_id'];
}
