<?php

namespace App\Filament\Widgets;

use App\Models\Event;
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
        $totalDestinasi  = Place::count();
        $published       = Place::where('status', 'published')->count();
        $totalUlasan     = Review::count();
        $ulasanBulanIni  = Review::whereMonth('created_at', now()->month)->count();
        $totalPengguna   = User::count();
        $userBaru        = User::whereMonth('created_at', now()->month)->count();
        $totalEvent      = Event::count();
        $eventAktif      = Event::where('is_active', true)->count();

        return [
            Stat::make('Total Destinasi', $totalDestinasi)
                ->description("{$published} destinasi terpublikasi")
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, $totalDestinasi]),

            Stat::make('Total Ulasan', $totalUlasan)
                ->description("{$ulasanBulanIni} ulasan baru bulan ini")
                ->descriptionIcon('heroicon-m-chat-bubble-left-ellipsis')
                ->color('primary')
                ->chart([3, 15, 4, 17, 7, 2, $totalUlasan]),

            Stat::make('Total Pengguna', $totalPengguna)
                ->description("{$userBaru} pengguna baru bulan ini")
                ->descriptionIcon('heroicon-m-users')
                ->color('warning')
                ->chart([2, 5, 8, 3, 9, 4, $totalPengguna]),

            Stat::make('Event & Trip', $totalEvent)
                ->description("{$eventAktif} event aktif")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
        ];
    }
}
