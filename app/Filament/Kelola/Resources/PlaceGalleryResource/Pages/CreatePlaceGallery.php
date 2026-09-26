<?php

namespace App\Filament\Kelola\Resources\PlaceGalleryResource\Pages;

use App\Filament\Kelola\Resources\PlaceGalleryResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePlaceGallery extends CreateRecord
{
    protected static string $resource = PlaceGalleryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
