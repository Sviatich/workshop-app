<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'length',
        'width',
        'height',
        'box_type_id',
        'cardboard_thickness',
        'cardboard_color',
        'cardboard_strength',
        'quantity',
        'print_type',
        'print_size',
        'need_logo_design',
        'design_file',
        'price_per_box',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function boxType()
    {
        return $this->belongsTo(BoxType::class);
    }
}
