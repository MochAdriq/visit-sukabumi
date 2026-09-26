<?php

namespace App\Filament\Dinas\Widgets;

use App\Models\RkudAccount;
use App\Models\TaxLedger;
use App\Models\TaxWithdrawal;
use Filament\Widgets\Widget;

class TaxWithdrawalOverviewWidget extends Widget
{
    protected static string $view = 'filament.dinas.widgets.tax-withdrawal-overview';
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $availableEscrow = (float) TaxLedger::where('status', 'held_in_escrow')->sum('tax_amount');
        $escrowTxCount = TaxLedger::where('status', 'held_in_escrow')->count();

        $totalDeposited = (float) TaxWithdrawal::where('status', 'transferred')->sum('total_amount');
        $transferredCount = TaxWithdrawal::where('status', 'transferred')->count();

        $pendingCount = TaxWithdrawal::where('status', 'pending')->count();
        $pendingAmount = (float) TaxWithdrawal::where('status', 'pending')->sum('total_amount');

        $approvedCount = TaxWithdrawal::where('status', 'approved')->count();
        $approvedAmount = (float) TaxWithdrawal::where('status', 'approved')->sum('total_amount');

        $activeRkud = RkudAccount::where('is_active', true)->first();

        // Tentukan URL Create sesuai panel aktif (Dinas atau Admin)
        $isAdmin = request()->is('admin*');
        $createUrl = $isAdmin 
            ? url('/admin/tax-withdrawals/create')
            : url('/dinas/tax-withdrawals/create');

        return [
            'availableEscrow' => $availableEscrow,
            'escrowTxCount' => $escrowTxCount,
            'totalDeposited' => $totalDeposited,
            'transferredCount' => $transferredCount,
            'pendingCount' => $pendingCount,
            'pendingAmount' => $pendingAmount,
            'approvedCount' => $approvedCount,
            'approvedAmount' => $approvedAmount,
            'activeRkud' => $activeRkud,
            'createUrl' => $createUrl,
        ];
    }
}
