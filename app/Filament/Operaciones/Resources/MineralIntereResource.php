<?php

namespace App\Filament\Operaciones\Resources;

use App\Filament\Clusters\ParametrosGeneralesExplora;
use App\Filament\Operaciones\Resources\MineralIntereResource\Pages;
use App\Filament\Operaciones\Resources\MineralIntereResource\RelationManagers;
use App\Models\MineralInteres;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MineralIntereResource extends Resource
{
    protected static ?string $model = MineralInteres::class;

         protected static ?string $navigationIcon = 'heroicon-o-document-text';

        protected static ?string $cluster = ParametrosGeneralesExplora::class;
        protected static ?string    $navigationLabel = 'Mineral de Interés';
        protected static ?string    $navigationGroup = 'Parametros';
        protected static ?string    $navigationParentItem = 'Parametros Generales';
        protected static ?string    $pluralModelLabel = 'Minerales de Interés';
        protected static ?string    $slug = '/MineralInteres';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListMineralInteres::route('/'),
            'create' => Pages\CreateMineralIntere::route('/create'),
            'edit' => Pages\EditMineralIntere::route('/{record}/edit'),
        ];
    }
}
