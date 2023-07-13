<?php

namespace App\Filament\Resources\Components\Fields;

use App\Traits\HasSignaturePadAttributes;
use Filament\Forms\Components\Field;

class SignaturePad extends Field
{
    use HasSignaturePadAttributes;

    protected string $view = 'filament-signature-pad::forms.components.fields.signature-pad';
}
