<?php

namespace App\Filament\Resources\SolicitudResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;


class MuestrasRelationManager extends RelationManager
{
    protected static string $relationship = 'muestras';

    public function form(Form $form): Form
    {

return $form
    ->schema([
        Grid::make(3)->schema([
            TextInput::make('codigo_consecutivo')
                ->label('Código Consecutivo')
                ->required()
                ->maxLength(255),
            TextInput::make('consecutivo')
                ->numeric()
                ->label('Consecutivo Interno')
                ->required(),
            TextInput::make('referencia_campo')
                ->label('Referencia de Campo'),
        ]),

        Select::make('tipo_muestra_id')
            ->label('Tipo de Muestra')
            ->relationship('tipoMuestra', 'nombre')
            ->required()
            ->searchable()
            ->preload(),

        Grid::make(2)->schema([
            TextInput::make('localizacion_geografica')
                ->label('Localización Geográfica'),
            TextInput::make('descripcion_preliminar')
                ->label('Descripción Preliminar'),
            TextInput::make('origen')
                ->label('Origen'),
            Textarea::make('observaciones')
                ->label('Observaciones')
                ->rows(3)
                ->columnSpanFull(),
        ]),

        Grid::make(4)->schema([
            TextInput::make('ph')
                ->label('pH')
                ->numeric()
                ->step(0.01),
            TextInput::make('temperatura')
                ->label('Temperatura (°C)')
                ->numeric()
                ->step(0.01),
            TextInput::make('conductividad')
                ->label('Conductividad (μS/cm)')
                ->numeric()
                ->step(0.01),
            TextInput::make('alcalinidad')
                ->label('Alcalinidad (mg/L)')
                ->numeric()
                ->step(0.01),
        ]),

        Grid::make(2)->schema([
            TextInput::make('norte')
                ->label('Coordenada Norte')
                ->numeric()
                ->step(0.000001),
            TextInput::make('este')
                ->label('Coordenada Este')
                ->numeric()
                ->step(0.000001),
        ]),

        Grid::make(3)->schema([
            Toggle::make('criterio_1')
                ->label('Muestra Identificable?'),
            Toggle::make('criterio_2')
                ->label('Embalaje Adecuado?'),
            Toggle::make('criterio_3')
                ->label('Cantidad Minima Requerida?'),
        ]),
    ]);

}

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('codigo_consecutivo')
            ->columns([
                Tables\Columns\TextColumn::make('consecutivo'),
                Tables\Columns\TextColumn::make('codigo_consecutivo')->searchable(),
                Tables\Columns\TextColumn::make('referencia_campo'),
                Tables\Columns\ToggleColumn::make('criterio_1')
                    ->disabled(true)
                    ->label('Identificable?'),
                Tables\Columns\ToggleColumn::make('criterio_2')
                    ->disabled(true)
                    ->label('Embalaje?'),
                Tables\Columns\ToggleColumn::make('criterio_3')
                    ->disabled(true)
                    ->label('Cantidad ?'),
                Tables\Columns\TextColumn::make('tipoMuestra.nombre')
                    ->label('Tipo de Muestra')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
