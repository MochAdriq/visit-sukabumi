<?php

namespace App\Filament\Kelola\Resources\PlaceGalleryResource\Pages;

use App\Filament\Kelola\Resources\PlaceGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlaceGallery extends EditRecord
{
    protected static string $resource = PlaceGalleryResource::class;

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
