<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GrupoTrabajoResource\Pages;
use App\Filament\Resources\GrupoTrabajoResource\RelationManagers;
use App\Models\GrupoTrabajo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Clusters\ParametrosGenerales;


class GrupoTrabajoResource extends Resource
{
    protected static ?string $model = GrupoTrabajo::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $cluster = ParametrosGenerales::class;
        protected static ?string    $navigationLabel = 'Grupo de Trabajo';
        protected static ?string    $navigationGroup = 'Parametros';
        protected static ?string    $navigationParentItem = 'Parametros Generales';
        protected static ?string    $pluralModelLabel = 'Grupos de Trabajo';
        protected static ?string    $slug = '/GrupoTrabajo';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('descripcion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('direccion_tecnica_id')
                    ->relationship('direccionTecnica', 'nombre')
                    ->required()
                    ->createOptionForm([
                            Forms\Components\TextInput::make('codigo')
                                ->required()
                                ->autocomplete(false)
                                ->maxLength(3),
                            Forms\Components\TextInput::make('nombre')
                                ->required()
                                ->autocomplete(false)
                                ->maxLength(255),
                                ]),
                Forms\Components\Select::make('responsable_id')
                    ->relationship('responsable', 'name')
                    ->required()
                    ->label('Responsable del Grupo de Trabajo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('responsable.name')
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
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
             RelationManagers\ProyectosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrupoTrabajos::route('/'),
            'create' => Pages\CreateGrupoTrabajo::route('/create'),
            'edit' => Pages\EditGrupoTrabajo::route('/{record}/edit'),
        ];
    }
}
