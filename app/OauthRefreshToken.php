<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthRefreshToken extends Model
{
    //
    protected $table = 'old_oauth_refresh_tokens';
    public $incrementing = false;
}
