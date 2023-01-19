<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
    protected $table = 'old_oauth_clients';
    public $incrementing = false;

    protected $fillable = ['id', 'secret', 'name'];
}
