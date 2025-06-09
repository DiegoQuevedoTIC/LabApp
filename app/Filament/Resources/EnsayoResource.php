<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnsayoResource\Pages;
use App\Filament\Resources\EnsayoResource\RelationManagers;
use App\Models\Ensayo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Clusters\ParametrosGenerales;

class EnsayoResource extends Resource
{
    protected static ?string $model = Ensayo::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

        protected static ?string $cluster = ParametrosGenerales::class;
        protected static ?string    $navigationLabel = 'Portafolio de Servicios';
        protected static ?string    $navigationGroup = 'Parametros';
        protected static ?string    $navigationParentItem = 'Parametros Generales';
        protected static ?string    $pluralModelLabel = 'Portafolio de Servicios';
        protected static ?string    $slug = '/PortafolioServicios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('clase_ensayo_id')
                    ->relationship('claseEnsayo', 'nombre')
                    ->required(),
                Forms\Components\Textarea::make('descripcion')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('documento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('soporte')
                    ->disk('public')
                    ->directory('ensayos')
                    ->visibility('public')
                    ->openable()
                    ->preserveFilenames(),
                Forms\Components\TextInput::make('valor')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('laboratorio_id')
                    ->relationship('laboratorio', 'nombre')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('documento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('valor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('laboratorio.nombre')
                    ->numeric()
                    ->sortable(),

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
            'index' => Pages\ListEnsayos::route('/'),
            'create' => Pages\CreateEnsayo::route('/create'),
            'edit' => Pages\EditEnsayo::route('/{record}/edit'),
        ];
    }
}
