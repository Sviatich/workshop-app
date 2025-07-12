<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'length',
        'width',
        'height',
        'box_type_id',
        'thickness',
        'color',
        'strength',
        'quantity',
        'print_type',
        'print_size',
        'need_logo_design',
        'design_file',
        'delivery_method',
        'delivery_address',
        'customer_type',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_inn',
        'uuid',
        'status',
        'price_per_box',
        'total_price',
        'volume',
        'weight',
    ];
}
