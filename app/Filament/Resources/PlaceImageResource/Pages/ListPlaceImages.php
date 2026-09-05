<?php

namespace App\Filament\Resources\PlaceImageResource\Pages;

use App\Filament\Resources\PlaceImageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaceImages extends ListRecords
{
    protected static string $resource = PlaceImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
