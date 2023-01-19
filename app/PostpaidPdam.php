<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostpaidPdam extends Model
{
    protected $table = 'postpaid_pdam';

    protected $guarded = [];

    protected $hidden = ['supplier_service_code', 'supplier_product_code', 'created_at', 'updated_at'];
}
