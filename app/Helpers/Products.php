<?php
/**
 * Created by PhpStorm.
 * User: infiniqa
 * Date: 26/12/16
 * Time: 14:35
 */

namespace App\Helpers;


use App\Helpers\Services\StatusProducts;

class Products
{
    public static function status(){
        return new StatusProducts();
    }
}