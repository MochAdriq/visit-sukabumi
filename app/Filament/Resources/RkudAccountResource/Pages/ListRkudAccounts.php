<?php

namespace App\Filament\Resources\RkudAccountResource\Pages;

use App\Filament\Resources\RkudAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRkudAccounts extends ListRecords
{
    protected static string $resource = RkudAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
