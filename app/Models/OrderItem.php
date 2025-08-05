<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'config_json', 'price_per_unit',
        'total_price', 'weight', 'volume'
    ];

    protected $casts = [
        'config_json' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class);
    }
}
