<?php

namespace App\Filament\Kelola\Resources\HotelRoomResource\Pages;

use App\Filament\Kelola\Resources\HotelRoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHotelRoom extends CreateRecord
{
    protected static string $resource = HotelRoomResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
