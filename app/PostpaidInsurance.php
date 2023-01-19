<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostpaidInsurance extends Model
{

    protected $guarded = [];

    protected $hidden = ['supplier_service_code', 'supplier_product_code', 'created_at', 'updated_at'];
}
