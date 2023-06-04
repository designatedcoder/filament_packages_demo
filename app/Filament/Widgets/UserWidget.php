<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class UserWidget extends BaseWidget
{
    protected function getCards(): array {
        return [
            Card::make('Your blog posts', auth()->user()->posts()->count())
        ];
    }

    public static function canView(): bool {
        // return auth()->user()->hasRole('user');
        return !auth()->user()->is_admin;
    }
}
