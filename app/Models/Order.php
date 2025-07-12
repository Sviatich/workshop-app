<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'uuid',
        'status',
        'total_price',
        'volume',
        'weight',
        'delivery_method',
        'delivery_address',
        'customer_type',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_inn',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
