<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    public $incrementing = false;

    protected $fillable = ['user_id', 'voucher_id', 'quantity'];
}
