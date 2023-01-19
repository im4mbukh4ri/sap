<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PpobFailedRefund extends Model
{
    public function ppob_transaction() {
      return $this->belongsTo('App\PpobTransaction');
    }
}
