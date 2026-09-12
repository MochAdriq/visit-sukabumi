<?php

namespace App\Filament\Resources\PlaceClaimResource\Pages;

use App\Filament\Resources\PlaceClaimResource;
use Filament\Resources\Pages\ListRecords;

class ListPlaceClaims extends ListRecords
{
    protected static string $resource = PlaceClaimResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
