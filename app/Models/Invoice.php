<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'design_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'product_name',
        'quantity',
        'unit_price',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'deposit_amount',
        'balance_amount',
        'payment_status',
        'invoice_status',
        'invoice_date',
        'due_date',
        'paid_date',
        'notes',
        'terms_conditions',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'balance_amount' => 'decimal:2',
    ];

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopePartial($query)
    {
        return $query->where('payment_status', 'partial');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now()->toDateString())
                    ->where('payment_status', '!=', 'paid');
    }

    public function isOverdue()
    {
        return $this->due_date < now()->toDateString() && $this->payment_status !== 'paid';
    }

    public function getFormattedInvoiceNumberAttribute()
    {
        return 'INV-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getFormattedTotalAttribute()
    {
        return 'RM ' . number_format($this->total_amount, 2);
    }

    public function getFormattedBalanceAttribute()
    {
        return 'RM ' . number_format($this->balance_amount, 2);
    }
}
