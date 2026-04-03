<?php

namespace App\Providers\Filament;

use App\Models\Empresa;
use Awcodes\LightSwitch\LightSwitchPlugin;
use Awcodes\QuickCreate\QuickCreatePlugin;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\VerificarEmpresaConfigurada;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->registration(Register::class)
            ->brandName(fn() => Empresa::actual()?->nombre_comercial ?? 'SigaWeb')
            ->brandLogo(fn() => Empresa::actual()?->logo
                ? Storage::url(Empresa::actual()->logo)
                : asset('images/sigaweb-logo.svg'))
            ->brandLogoHeight('4rem')
            ->favicon(asset('images/sigaweb-icon.svg'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->multiFactorAuthentication([
                AppAuthentication::make()->recoverable(),
                EmailAuthentication::make()
            ], isRequired: false
            )
            ->breadcrumbs(false)
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn() => view('filament.footer')
            )
            ->databaseNotifications()
            ->databaseNotificationsPolling('60s')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([               
            ])
            ->navigationGroups([
                'Administración',
                'Configuración',
                'Inventario',
                'Compras',
                'Ventas',
                'Operaciones',
                'Bancos',
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
                VerificarEmpresaConfigurada::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                LightSwitchPlugin::make()->enabledOn(['auth.email', 'auth.password', 'auth.profile', 'auth.register']),
                FilamentBackgroundsPlugin::make(),
                QuickCreatePlugin::make(),
            FilamentEditProfilePlugin::make()
                ->shouldShowDeleteAccountForm(false)
                ->shouldShowBrowserSessionsForm()
                ->shouldShowAvatarForm(
                    value: true,
                    directory: 'avatars',
                    rules: 'mimes:jpeg,png|max:1024'
                )
                ->shouldShowMultiFactorAuthentication()
                ->shouldRegisterNavigation()
                ->shouldShowEmailForm()
                ->shouldShowSanctumTokens(),

        ]);
    }
}
