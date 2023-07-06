<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Spatie\Activitylog\Models\Activity;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\ActivityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ActivityResource\RelationManagers;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            TextInput::make('id'),
                            TextInput::make('causer_id')
                                ->label('Logged By'),
                            TextInput::make('description'),
                            TextInput::make('causer_type')
                                ->label('Model'),
                            TextInput::make('properties.old.name')
                                ->label('Old Name'),
                            TextInput::make('properties.attributes.name')
                                ->label('New Name'),
                            TextInput::make('properties.old.email')
                                ->label('Old Email'),
                            TextInput::make('properties.attributes.email')
                                ->label('New Email'),
                            TextInput::make('properties.old.is_admin')
                                ->label('Old Is Admin'),
                            TextInput::make('properties.attributes.is_admin')
                                ->label('New Is Admin'),
                            DateTimePicker::make('created_at')
                                ->label('Created'),
                            DateTimePicker::make('updated_at')
                                ->label('Updated'),
                        ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('causer_id')
                    ->label('Logged By'),
                TextColumn::make('description'),
                TextColumn::make('causer_type')
                    ->label('Model'),
                TextColumn::make('properties')
                    ->label('Attributes'),
                TextColumn::make('created_at')
                    ->label('Logged At')
                    ->dateTime('d-M-Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'view' => Pages\ViewActivity::route('/{record}'),
        ];
    }
}
