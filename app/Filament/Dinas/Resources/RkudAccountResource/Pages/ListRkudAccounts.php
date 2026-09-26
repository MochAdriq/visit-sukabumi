<?php

namespace App\Filament\Dinas\Resources\RkudAccountResource\Pages;

use App\Filament\Dinas\Resources\RkudAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRkudAccounts extends ListRecords
{
    protected static string $resource = RkudAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Rekening RKUD'),
        ];
    }
}
