<?php

namespace App\Filament\Kelola\Resources\ReviewManagementResource\Pages;

use App\Filament\Kelola\Resources\ReviewManagementResource;
use Filament\Resources\Pages\ListRecords;

class ListReviewManagement extends ListRecords
{
    protected static string $resource = ReviewManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
