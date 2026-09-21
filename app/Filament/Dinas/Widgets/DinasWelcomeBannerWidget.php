<?php

namespace App\Filament\Dinas\Widgets;

use App\Models\RkudAccount;
use App\Models\TaxLedger;
use Filament\Widgets\Widget;

class DinasWelcomeBannerWidget extends Widget
{
    protected static string $view = 'filament.dinas.widgets.welcome-banner';
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $availableEscrow = (float) TaxLedger::where('status', 'held_in_escrow')->sum('tax_amount');
        $activeRkud = RkudAccount::where('is_active', true)->first();

        return [
            'availableEscrow' => $availableEscrow,
            'activeRkud' => $activeRkud,
        ];
    }
}
