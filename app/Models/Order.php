<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'payer_type', 'full_name', 'email', 'phone', 'inn',
        'delivery_method_id', 'delivery_price', 'delivery_address',
        'total_price', 'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function deliveryMethod()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }
}
