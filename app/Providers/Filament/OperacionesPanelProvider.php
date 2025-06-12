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
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class OperacionesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('operaciones')
            ->path('operaciones')
            ->brandName('Explora')
            ->login()
            ->passwordReset()
            ->profile()
            ->maxContentWidth(MaxWidth::ScreenExtraLarge)
            ->font('Roboto')
            ->collapsibleNavigationGroups()
            ->sidebarFullyCollapsibleOnDesktop()
            ->brandName('Explora')
            ->brandLogo(asset('images/IconsExplora.png'))
            ->darkModeBrandLogo(asset('images/IconsExplora1.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('images/Icons.png'))
            ->colors([
                'primary' => Color::Teal,         // Verde institucional, para acciones clave
                'secondary' => Color::Slate,      // Gris oscuro, elegante como neutral de soporte
                'info' => Color::Indigo,          // Azul profundo, para información relevante
                'success' => Color::Green,        // Verde más claro, usado en confirmaciones
                'warning' => Color::Amber,        // Amarillo para advertencias suaves
                'danger' => Color::Rose,          // Rojo para errores
                'gray' => Color::Zinc,            // Gris claro para UI general y fondos
            ])
            ->discoverResources(in: app_path('Filament/Operaciones/Resources'), for: 'App\\Filament\\Operaciones\\Resources')
            ->discoverPages(in: app_path('Filament/Operaciones/Pages'), for: 'App\\Filament\\Operaciones\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Operaciones/Widgets'), for: 'App\\Filament\\Operaciones\\Widgets')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
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
