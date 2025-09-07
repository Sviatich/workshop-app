<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'payer_type', 'full_name', 'email', 'phone', 'inn', 'company_name',
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

    protected static function booted(): void
    {
        static::deleting(function (Order $order) {
            try {
                $dir = "order_files/{$order->uuid}";
                if (Storage::disk('public')->exists($dir)) {
                    Storage::disk('public')->deleteDirectory($dir);
                }
            } catch (\Throwable $e) {
                \Log::warning('Order files cleanup failed', [
                    'order_id' => $order->id ?? null,
                    'uuid' => $order->uuid ?? null,
                    'message' => $e->getMessage(),
                ]);
            }
        });
    }

    public function isExpired(): bool
    {
        $days = (int) config('orders.expiration_days', 30);
        return $this->created_at && $this->created_at->copy()->addDays($days)->isPast();
    }
}
