<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxLedger extends Model
{
    protected $fillable = [
        'booking_id',
        'tax_setting_id',
        'sector',
        'vendor_name',
        'tax_amount',
        'status',
        'tax_withdrawal_id',
        'withdrawn_at',
    ];

    protected $casts = [
        'tax_amount' => 'decimal:2',
        'withdrawn_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function taxSetting(): BelongsTo
    {
        return $this->belongsTo(TaxSetting::class);
    }

    public function taxWithdrawal(): BelongsTo
    {
        return $this->belongsTo(TaxWithdrawal::class);
    }
}
