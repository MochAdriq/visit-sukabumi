<?php

namespace App\Filament\Kelola\Resources\MyEventResource\Pages;

use App\Filament\Kelola\Resources\MyEventResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMyEvent extends CreateRecord
{
    protected static string $resource = MyEventResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
