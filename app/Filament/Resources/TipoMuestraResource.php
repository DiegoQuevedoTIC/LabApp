<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipoMuestraResource\Pages;
use App\Filament\Resources\TipoMuestraResource\RelationManagers;
use App\Models\TipoMuestra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Clusters\ParametrosGenerales;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TipoMuestraResource extends Resource
{
    protected static ?string $model = TipoMuestra::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';

        protected static ?string $cluster = ParametrosGenerales::class;
        protected static ?string    $navigationLabel = 'Tipo de Muestra';
        protected static ?string    $navigationGroup = 'Parametros';
        protected static ?string    $navigationParentItem = 'Parametros Generales';
        protected static ?string    $pluralModelLabel = 'Tipos de Muestra';
        protected static ?string    $slug = '/TipoMuestra';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTipoMuestras::route('/'),
            'create' => Pages\CreateTipoMuestra::route('/create'),
            'edit' => Pages\EditTipoMuestra::route('/{record}/edit'),
        ];
    }
}
