<?php

namespace App\Filament\Kelola\Resources\MyEventResource\Pages;

use App\Filament\Kelola\Resources\MyEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMyEvent extends EditRecord
{
    protected static string $resource = MyEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_page')
                ->label('Buka Halaman Publik')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(fn () => url('/event/' . $this->record->slug))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
