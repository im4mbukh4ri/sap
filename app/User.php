<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password', 'type_user_id', 'type', 'role', 'username', 'address_id', 'gender', 'birth_date', 'actived', 'upline', 'created_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at', 'referral', 'parent', 'address_id', 'pin', 'pin_attempt_granted', 'temporary_lock', 'password_attempt_granted'
    ];

    public function limit_paxpaid()
    {
        $limit = $this->type_user();
        return $limit->limit_paxpaid();
    }

    public function type_user()
    {
        return $this->belongsTo('App\TypeUser');
    }

    public function childs()
    {
        return $this->hasMany('App\User', 'upline');
    }

    public function parent()
    {
        return $this->belongsTo('App\User', 'upline');
    }

    public function hasParent()
    {
        return $this->upline > 0;
    }

    public function hasChild()
    {
        return $this->childs()->count() > 0;
    }

    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function travel_agent()
    {
        return $this->hasOne('App\TravelAgent');
    }

    public function referral()
    {
        return $this->hasOne('App\UserReferral');
    }

    public function banks()
    {
        return $this->hasMany('App\UserBank');
    }

    public function history_deposits()
    {
        return $this->hasMany('App\HistoryDeposit');
    }

    public function history_points()
    {
        return $this->hasMany('App\HistoryPoint');
    }

    public function ppob_transactions()
    {
        return $this->hasMany('App\PpobTransaction');
    }

    public function airlines_transactions()
    {
        return $this->hasMany('App\AirlinesTransaction');
    }

    public function train_transactions()
    {
        return $this->hasMany('App\TrainTransaction');
    }

    public function hotel_transactions()
    {
        return $this->hasMany('App\HotelTransaction');
    }

    public function ticket_deposits()
    {
        return $this->hasMany('App\TicketDeposit');
    }

    public function client_secrets()
    {
        return $this->hasMany('App\OauthClientSecret');
    }

    public static function statusList()
    {
        return ['Lock', 'Aktif', 'Unverified'];
    }

    public function getStatusActiveAttribute()
    {
        return static::statusList()[$this->actived];
    }

    public function number_saveds()
    {
        return $this->hasMany('App\NumberSaved');
    }

    public function request_reset_passwords()
    {
        return $this->hasMany('App\RequestResetPassword');
    }

    public function autodebits()
    {
        return $this->hasMany('App\Autodebit');
    }

    public function logs()
    {
        return $this->hasMany('App\UserLog');
    }

    public function socialAccount()
    {
        return $this->hasOne('App\SocialAccount');
    }

    public function deposits()
    {
        return $this->hasMany('App\Deposit', 'created_by');
    }

    public function getTelephone()
    {
        return $this->address()->first()->phone;
    }

    public function getReferral()
    {
        return $this->referral()->first()->referral;
    }

    public function user_location()
    {
        return $this->hasMany('App\UserLocation');
    }

    public function user_location_android()
    {
        return $this->user_location()->where('device', '=', 'android');
    }

    public function user_location_ios()
    {
        return $this->user_location()->where('device', '=', 'ios');
    }

    public function questionnaire_results()
    {
        return $this->hasMany('App\QuestionnaireResult');
    }

    public function photo()
    {
        return $this->hasOne('App\UserPhoto', 'user_id');
    }

    public function content_viewers()
    {
        return $this->hasMany('\App\UserContentViewer');
    }

    public function vouchers()
    {
        return $this->hasMany('App\UserVoucher', 'user_id');
    }

}
