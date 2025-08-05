<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructionSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'construction_id', 'length', 'width', 'height'
    ];

    public function construction()
    {
        return $this->belongsTo(Construction::class);
    }
}
