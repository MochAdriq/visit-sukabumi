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

class KelolaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('kelola')
            ->path('kelola')
            ->colors([
                'primary' => Color::hex('#1a6bbf'),
            ])
            ->brandName('Portal Mitra — Visit Sukabumi')
            ->discoverResources(in: app_path('Filament/Kelola/Resources'), for: 'App\\Filament\\Kelola\\Resources')
            ->discoverPages(in: app_path('Filament/Kelola/Pages'), for: 'App\\Filament\\Kelola\\Pages')
            ->pages([
                \App\Filament\Kelola\Pages\KelolaDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Kelola/Widgets'), for: 'App\\Filament\\Kelola\\Widgets')
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
            ])
            ->login(false); // Redirect ke profil jika tidak terautentikasi
    }
}
