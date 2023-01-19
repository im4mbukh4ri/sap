<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'master_transactions';
    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    public $incrementing = false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(MasterTransactionDetail::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function payment_service()
    {
        return $this->belongsTo(PaymentService::class, 'payment_service_id');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = v4();
        });
    }
}
