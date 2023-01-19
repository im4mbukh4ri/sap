<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobInquiry extends Model
{

    protected $fillable = ['user_id', 'product_id', 'number', 'price', 'commission', 'admin', 'status_payment'];

    public $incrementing = false;

    protected $keyType = 'string';
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = uniqid();
        });
    }
}
