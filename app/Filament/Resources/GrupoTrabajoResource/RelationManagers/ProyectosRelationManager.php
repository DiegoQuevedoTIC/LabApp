<?php

namespace App\Filament\Resources\GrupoTrabajoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProyectosRelationManager extends RelationManager
{
    protected static string $relationship = 'proyectos';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Grid::make(3)
                ->schema([
                    Forms\Components\TextInput::make('codigo')
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->columnSpan(1),

                    Forms\Components\TextInput::make('nombre')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                ]),

            Forms\Components\TextInput::make('descripcion')
                ->required()
                ->maxLength(255)
                ->columnSpanFull(), // Esto hace que abarque las 3 columnas
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                Tables\Columns\TextColumn::make('codigo'),
                Tables\Columns\TextColumn::make('nombre'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
}
