<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class AdminWidget extends BaseWidget
{
    protected function getCards(): array {
        return [
            Card::make('Unique views', '192.1k')
                ->description('32k increase')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-s-trending-up'),
            Card::make('Bounce rate', '21%')
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-down'),
            Card::make('Average time on page', '3:12')
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up'),
        ];
    }

    public static function canView(): bool {
        return auth()->user()->hasAnyRole(['super-admin', 'admin', 'moderator', 'developer']);
        // return auth()->user()->is_admin;
    }
}
