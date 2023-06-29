<?php

namespace App\Http\Responses;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Redirector;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse | Redirector {
        auth()->user()->update([
            'is_active' => 1
        ]);

        return redirect()->intended(Filament::getUrl());
    }
}
