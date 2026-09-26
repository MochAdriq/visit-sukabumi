<?php

namespace App\Filament\Kelola\Resources\HotelRoomResource\Pages;

use App\Filament\Kelola\Resources\HotelRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHotelRooms extends ListRecords
{
    protected static string $resource = HotelRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tipe Kamar'),
        ];
    }
}
