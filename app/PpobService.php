<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpobService extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = ['parent_id', 'created_at', 'updated_at', 'deleted_at'];

    public function childs()
    {
        return $this->hasMany('App\PpobService', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('App\PpobService', 'parent_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\PpobTransaction', 'ppob_service_id');
    }

    public function pulsa_commission()
    {
        return $this->belongsToMany('App\IdrCommission', 'ppob_service_commissions', 'ppob_service_id');
    }

    public function pulsa_markup()
    {
        return $this->belongsToMany('App\IdrMarkup', 'ppob_service_markups', 'ppob_service_id');
    }

    public function pulsa_bv_markup()
    {
        return $this->belongsToMany('App\IdrMarkup', 'ppob_service_bv_markups', 'ppob_service_id');
    }

    public function pulsa_price()
    {
        return $this->belongsToMany('App\IdrPrice', 'ppob_service_prices', 'ppob_service_id');
    }
}
