<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cart extends Model
{
    protected $table = 'carts';
    public $timestamps = false;

    protected function product(): HasOne {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
