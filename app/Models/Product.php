<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'collar_type',
        'fabric_type',
        'sleeve_type',
        'image_path',
    ];

    protected $casts = [
        'collar_type' => 'array',
        'fabric_type' => 'array',
        'sleeve_type' => 'array',
    ];
}
