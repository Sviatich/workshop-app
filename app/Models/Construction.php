<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Construction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'image', 'animation', 'bigpicture'
    ];

    public function sizes()
    {
        return $this->hasMany(ConstructionSize::class);
    }
}
