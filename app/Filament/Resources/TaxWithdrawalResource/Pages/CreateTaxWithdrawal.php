<?php

namespace App\Filament\Resources\TaxWithdrawalResource\Pages;

use App\Filament\Resources\TaxWithdrawalResource;
use App\Models\TaxLedger;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTaxWithdrawal extends CreateRecord
{
    protected static string $resource = TaxWithdrawalResource::class;

    protected static ?string $title = 'Formulir Penyetoran Pajak ke Kas Daerah (RKUD)';

    public function getSubheading(): ?string
    {
        return 'Proses pemindahbukuan saldo Pajak Barang dan Jasa Tertentu (PBJT 10%) dari rekening penampung escrow ke Rekening Kas Umum Daerah (RKUD) Kabupaten Sukabumi pada Bank BJB.';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $availableBalance = (float) TaxLedger::where('status', 'held_in_escrow')->sum('tax_amount');

        if ($availableBalance <= 0) {
            Notification::make()
                ->title('Saldo Escrow Kosong')
                ->body('Tidak ada saldo pajak daerah di rekening penampung (escrow) yang dapat ditarik saat ini.')
                ->danger()
                ->send();

            $this->halt();
        }

        $requestedAmount = (float) ($data['total_amount'] ?? 0);
        if ($requestedAmount > $availableBalance) {
            Notification::make()
                ->title('Nominal Melebihi Saldo Escrow')
                ->body('Nominal penarikan (Rp ' . number_format($requestedAmount, 0, ',', '.') . ') melebihi saldo escrow yang tersedia (Rp ' . number_format($availableBalance, 0, ',', '.') . ').')
                ->danger()
                ->send();

            $this->halt();
        }

        $data['withdrawal_code'] = sprintf('TAX-WD-%s-%s', date('Ym'), strtoupper(Str::random(5)));
        $data['requested_by'] = auth()->id();
        $data['status'] = 'pending';

        return $data;
    }

    protected function afterCreate(): void
    {
        $withdrawal = $this->record;

        // Tandai mutasi pajak di escrow yang ditarik menjadi ready_for_withdrawal
        $ledgers = TaxLedger::where('status', 'held_in_escrow')->get();
        $remaining = (float) $withdrawal->total_amount;

        foreach ($ledgers as $ledger) {
            if ($remaining <= 0) break;

            $ledger->update([
                'status' => 'ready_for_withdrawal',
                'tax_withdrawal_id' => $withdrawal->id,
            ]);

            $remaining -= (float) $ledger->tax_amount;
        }

        Notification::make()
            ->title('Pengajuan Penyetoran Berhasil')
            ->body("Pengajuan kode {$withdrawal->withdrawal_code} berhasil dibuat dengan status MENUNGGU PERSETUJUAN.")
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
