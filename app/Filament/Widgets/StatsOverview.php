<?php

namespace App\Filament\Widgets;

use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Destinasi', Place::count())
                ->description('Destinasi wisata terdaftar')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),
            Stat::make('Total Ulasan Masuk', Review::count())
                ->description('Interaksi pengunjung')
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('primary')
                ->chart([3, 15, 4, 17, 7, 2, 10]),
            Stat::make('Total Pengguna', User::count())
                ->description('Pengunjung terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}
