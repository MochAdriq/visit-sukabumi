<?php

namespace App\Filament\Dinas\Resources\TaxSettingResource\Pages;

use App\Filament\Dinas\Resources\TaxSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxSetting extends EditRecord
{
    protected static string $resource = TaxSettingResource::class;

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
