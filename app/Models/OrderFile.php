<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id', 'file_path', 'file_type'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
