<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class DinasPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('dinas')
            ->path('dinas')
            ->colors([
                'primary' => Color::hex('#163766'),
            ])
            ->brandName('Portal Pajak Daerah — Bapenda Kab. Sukabumi')
            ->favicon(asset('assets/images/logo-v2.png'))
            ->login()
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationGroups([
                '1. Penyetoran Kas Daerah',
                '2. Pembukuan & Pengawasan',
                '3. Kebijakan & Rekening',
            ])
            ->resources([
                \App\Filament\Resources\TaxWithdrawalResource::class,
                \App\Filament\Resources\TaxLedgerResource::class,
                \App\Filament\Resources\BookingResource::class,
                \App\Filament\Resources\RkudAccountResource::class,
                \App\Filament\Resources\TaxSettingResource::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Dinas/Widgets'), for: 'App\\Filament\\Dinas\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
