<?php

namespace App\Filament\Resources\PlaceImageResource\Pages;

use App\Filament\Resources\PlaceImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlaceImage extends EditRecord
{
    protected static string $resource = PlaceImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
