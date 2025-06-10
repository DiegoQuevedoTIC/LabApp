<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaseEnsayoResource\Pages;
use App\Filament\Resources\ClaseEnsayoResource\RelationManagers;
use App\Models\ClaseEnsayo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Clusters\ParametrosGenerales;

class ClaseEnsayoResource extends Resource
{
    protected static ?string $model = ClaseEnsayo::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

        protected static ?string $cluster = ParametrosGenerales::class;
        protected static ?string    $navigationLabel = 'Clase de Ensayo';
        protected static ?string    $navigationGroup = 'Parametros';
        protected static ?string    $navigationParentItem = 'Parametros Generales';
        protected static ?string    $pluralModelLabel = 'Clases de Ensayo';
        protected static ?string    $slug = '/ClasesEnsayo';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                    ->required()
                    ->columnSpan(3)
                    ->maxLength(255),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
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
            'index' => Pages\ListClaseEnsayos::route('/'),
            'create' => Pages\CreateClaseEnsayo::route('/create'),
            'edit' => Pages\EditClaseEnsayo::route('/{record}/edit'),
        ];
    }
}
