<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'construction_id', 'length', 'width', 'height', 'stock'
    ];

    public function construction()
    {
        return $this->belongsTo(Construction::class);
    }
}
