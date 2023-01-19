<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//use App\Models\Airlines\AirlinesTransaction;

class MasterTransactionDetail extends Model
{
    protected $table = 'master_transaction_details';
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

    /**
     * Hidden column attributes on the model
     *
     * @var array
     */

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function master_transaction()
    {
        return $this->belongsTo(MasterTransaction::class, 'master_transaction_id');
    }

    protected $hidden = ['created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = v4();
        });
    }
}
