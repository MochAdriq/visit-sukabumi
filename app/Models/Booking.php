<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'booking_type',
        'bookable_type',
        'bookable_id',
        'source_title',
        'check_in_date',
        'check_out_date',
        'quantity',
        'base_price',
        'subtotal_amount',
        'tax_rate_percent',
        'tax_amount',
        'platform_fee',
        'total_amount',
        'payment_status',
        'payment_method',
        'payment_reference',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'quantity' => 'integer',
        'base_price' => 'decimal:2',
        'subtotal_amount' => 'decimal:2',
        'tax_rate_percent' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function taxLedger(): HasOne
    {
        return $this->hasOne(TaxLedger::class);
    }
}
