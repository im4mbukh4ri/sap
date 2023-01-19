<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $guarded = [];

    protected $hidden = ['is_show', 'created_at', 'updated_at'];

    /**
     * Child
     *
     * @return HasMany
     */
    public function child()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
//            ->where('id', '!=', 433)->where('id', '!=', 35);
    }

    /**
     * Parent
     *
     * @return Object
     */
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    /**
     * Has child
     *
     * @return boolean
     */
    public function hasChild()
    {
        if ($this->child) {
            return true;
        }
        return false;
    }

    /**
     * Has parent
     *
     * @return boolean
     */
    public function hasParent()
    {
        if ($this->parent) {
            return true;
        }
        return false;
    }
}
