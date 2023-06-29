<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Filament\Facades\Filament;
use App\Http\Controllers\Controller;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) {
        auth()->user()->update([
            'is_active' => 0
        ]);

        Filament::auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return app(LogoutResponse::class);
    }
}
