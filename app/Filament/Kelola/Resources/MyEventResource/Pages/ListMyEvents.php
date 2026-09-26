<?php

namespace App\Filament\Kelola\Resources\MyEventResource\Pages;

use App\Filament\Kelola\Resources\MyEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMyEvents extends ListRecords
{
    protected static string $resource = MyEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Buat Event Baru')
                ->icon('heroicon-o-plus'),
        ];
    }
}
