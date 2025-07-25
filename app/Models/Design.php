<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'design_path',
        'total_qty',
        'collar_type',
        'fabric_type',
        'sleeve_type',
        'total_price',
        'status',
        'deposit_proof_path',
        'fullpayment_proof_path',
    ];

    protected $casts = [
        'collar_type' => 'array',
        'fabric_type' => 'array',
        'sleeve_type' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
} 