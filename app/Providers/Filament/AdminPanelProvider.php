<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Blade; // <-- Import Blade facade

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->brandName('HMIS Pro')
            ->brandLogo(fn () => view('filament.admin.logo'))
            ->favicon(asset('images/favicon1.ico'))
            ->colors([
                'primary' => Color::Amber,
                'gray' => Color::Slate,
            ])
            ->darkMode(true)
            // Inject custom styles directly into the head
            ->renderHook(
                'panels::head.end',
                fn (): string => Blade::render('<style>
                    /* ------------------ LIGHT MODE ------------------ */

                    /* Sidebar Background */
                    .fi-sidebar {
                        background-color: #1f2937 !important; /* Dark Slate */
                    }

                    /* Sidebar Text (Navigation Links & Group Headers) */
                    .fi-sidebar .fi-sidebar-item-label,
                    .fi-sidebar .fi-sidebar-group-label {
                        color: #d1d5db !important; /* Light Gray */
                    }

                    /* Sidebar Active/Hover Text */
                    .fi-sidebar-item-active .fi-sidebar-item-label,
                    .fi-sidebar-item a:hover .fi-sidebar-item-label,
                    .fi-sidebar-item button:hover .fi-sidebar-item-label {
                        color: #1f2937  !important;
                    }

                    /* Sidebar Brand/Logo Text */
                    .fi-sidebar .fi-brand {
                        color: #93c5fd !important; /* Light Blue */
                    }

                    /* Main Content Background */
                    .fi-main {
                        background-color: #f9fafb !important; /* Very Light Gray */
                    }

                    /* ------------------ DARK MODE ------------------ */

                    /* Dark Mode Sidebar Background */
                    .dark .fi-sidebar {
                        background-color: #0f172a !important; /* Darker Slate */
                    }

                    /* Main Content Background */
                    .dark .fi-main {
                        background-color: #111827 !important; /* Dark Gray */
                    }
                    .dark .fi-sidebar-item-active .fi-sidebar-item-label,
                    .fi-sidebar-item a:hover .fi-sidebar-item-label,
                    .fi-sidebar-item button:hover .fi-sidebar-item-label {
                        color: #fff !important;
                    }
                </style>'),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
            ->navigationGroups([
                NavigationGroup::make()->label('Clinical')->icon('heroicon-o-heart'),
                NavigationGroup::make()->label('Billing')->icon('heroicon-o-currency-dollar'),
                NavigationGroup::make()->label('Catalogs')->icon('heroicon-o-book-open')->collapsed(),
                NavigationGroup::make()->label('Admin')->icon('heroicon-o-cog-6-tooth')->collapsed(),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
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

