<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected function orderItems(): HasMany {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
