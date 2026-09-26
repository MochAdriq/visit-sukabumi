<?php

namespace App\Filament\Dinas\Resources\RkudAccountResource\Pages;

use App\Filament\Dinas\Resources\RkudAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRkudAccount extends EditRecord
{
    protected static string $resource = RkudAccountResource::class;

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
