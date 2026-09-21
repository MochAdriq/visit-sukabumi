<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RkudAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder_name',
        'agency_name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function taxWithdrawals(): HasMany
    {
        return $this->hasMany(TaxWithdrawal::class);
    }
}
