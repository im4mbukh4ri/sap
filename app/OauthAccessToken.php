<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    //
    protected $table = 'old_oauth_access_tokens';
    public $incrementing = false;
}
