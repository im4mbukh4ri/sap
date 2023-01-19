<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrepaidTransaction extends Model
{
    public function commission()
    {
        return $this->hasOne(PrepaidCommission::class);
    }
}
