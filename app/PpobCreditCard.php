<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobCreditCard extends Model
{
    protected $fillable = ['ppob_transaction_id', 'customer_name', 'nominal', 'admin', 'ref', 'created_at', 'updated_at'];
}
