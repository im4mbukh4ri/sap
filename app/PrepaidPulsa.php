<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrepaidPulsa extends Model
{
    protected $table = 'prepaid_pulsa';

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = ['id', 'supplier_transaction_id', 'supplier_service_code', 'supplier_product_code'];
}
