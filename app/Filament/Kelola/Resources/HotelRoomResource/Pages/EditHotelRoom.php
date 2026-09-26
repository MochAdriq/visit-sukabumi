<?php

namespace App\Filament\Kelola\Resources\HotelRoomResource\Pages;

use App\Filament\Kelola\Resources\HotelRoomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotelRoom extends EditRecord
{
    protected static string $resource = HotelRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
