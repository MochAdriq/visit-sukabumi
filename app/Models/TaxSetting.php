<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaxSetting extends Model
{
    protected $fillable = [
        'category',
        'name',
        'rate_percent',
        'is_active',
        'description',
    ];

    protected $casts = [
        'rate_percent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function taxLedgers(): HasMany
    {
        return $this->hasMany(TaxLedger::class);
    }
}
