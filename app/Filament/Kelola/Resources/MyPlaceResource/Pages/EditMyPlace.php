<?php

namespace App\Filament\Kelola\Resources\MyPlaceResource\Pages;

use App\Filament\Kelola\Resources\MyPlaceResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditMyPlace extends EditRecord
{
    protected static string $resource = MyPlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Informasi destinasi berhasil diperbarui!';
    }
}
