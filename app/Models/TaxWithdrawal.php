<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxWithdrawal extends Model
{
    protected $fillable = [
        'withdrawal_code',
        'rkud_account_id',
        'requested_by',
        'approved_by',
        'total_amount',
        'status',
        'transfer_proof_path',
        'notes',
        'transferred_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'transferred_at' => 'datetime',
    ];

    public function rkudAccount(): BelongsTo
    {
        return $this->belongsTo(RkudAccount::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function taxLedgers(): HasMany
    {
        return $this->hasMany(TaxLedger::class);
    }
}
