<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use DutchCodingCompany\FilamentSocialite\Facades\FilamentSocialite as FilamentSocialiteFacade;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        $this->app->bind(LoginResponse::class, \App\Http\Responses\LoginResponse::class);

        FilamentSocialiteFacade::setCreateUserCallback(fn (SocialiteUserContract $oauthUser, FilamentSocialite $socialite) => $socialite->getUserModelClass()::create([
            'name' => $oauthUser->getName(),
            'email' => $oauthUser->getEmail(),
            'password' => Hash::make(Str::random(7)),
        ]));

        Filament::serving(function() {
            Filament::registerNavigationItems([
                NavigationItem::make('Settings')
                    ->url(route('filament.pages.settings'))
                    ->icon('heroicon-o-cog'),
            ]);
        });

        \Reworck\FilamentSettings\FilamentSettings::setFormFields([
            \Filament\Forms\Components\TextInput::make('title'),
            \Filament\Forms\Components\TextInput::make('footer'),
        ]);
    }
}
