<?php

namespace App\Filament\Kelola\Resources\PlaceGalleryResource\Pages;

use App\Filament\Kelola\Resources\PlaceGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaceGalleries extends ListRecords
{
    protected static string $resource = PlaceGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Unggah Foto Baru'),
        ];
    }
}
