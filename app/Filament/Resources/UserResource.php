<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\Components\Fields\SignaturePad;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        SignaturePad::make('signature'),
                        Toggle::make('is_admin')
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->password()
                            ->maxLength(255)
                            ->dehydrateStateUsing(static fn (null|string $state): null|string =>
                                filled($state) ? Hash::make($state): null,
                            )->required(static fn (Page $livewire): bool =>
                                $livewire instanceof CreateUser,
                            )->dehydrated(static fn (null|string $state): bool =>
                                filled($state),
                            )->label(static fn (Page $livewire): string =>
                                ($livewire instanceof EditUser) ? 'New Password' : 'Password'
                            ),
                        CheckboxList::make('roles')
                            ->relationship('roles', 'name')
                            ->columns(2)
                            ->helperText('Only Choose One!')
                            ->required()
                    ])
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('name')->sortable(),
                BadgeableColumn::make('name')
                    ->badges([
                        Badge::make('is_active')
                            ->label('Active')
                            ->color('success')
                            ->visible(fn ($record) : bool => $record->is_active ?? false),
                    ])
                ->searchable()
                ->sortable(),
                IconColumn::make('is_admin')->boolean()->sortable(),
                TextColumn::make('roles.name')->sortable(),
                TextColumn::make('email')->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array {
        return [
            RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
