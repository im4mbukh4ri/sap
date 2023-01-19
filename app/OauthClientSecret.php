<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthClientSecret extends Model
{
    //
    protected $table = 'old_oauth_client_secrets';
    protected $fillable = ['user_id', 'client_id', 'client_secret', 'device_type', 'device_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sessions()
    {
        return $this->hasMany('App\OauthSession', 'client_id', 'client_id');
    }
}
