<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $appends = ['payment_service', 'detail'];

    protected $hidden = ['updated_at', 'created_at', 'verifiable_type', 'verifiable_id', 'detailable_type', 'detailable_id'];

    public function master_transaction()
    {
        return $this->belongsTo(MasterTransaction::class);
    }

    public function detailable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = v4();
        });
    }
}
