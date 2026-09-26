<?php

namespace App\Filament\Dinas\Resources\TaxSettingResource\Pages;

use App\Filament\Dinas\Resources\TaxSettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTaxSetting extends CreateRecord
{
    protected static string $resource = TaxSettingResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
