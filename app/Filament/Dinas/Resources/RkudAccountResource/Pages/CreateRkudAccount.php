<?php

namespace App\Filament\Dinas\Resources\RkudAccountResource\Pages;

use App\Filament\Dinas\Resources\RkudAccountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRkudAccount extends CreateRecord
{
    protected static string $resource = RkudAccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
