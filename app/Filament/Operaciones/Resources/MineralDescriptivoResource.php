<?php

namespace App\Filament\Operaciones\Resources;

use App\Filament\Clusters\ParametrosGeneralesExplora;
use App\Filament\Operaciones\Resources\MineralDescriptivoResource\Pages;
use App\Filament\Operaciones\Resources\MineralDescriptivoResource\RelationManagers;
use App\Models\MineralDescriptivo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MineralDescriptivoResource extends Resource
{
    protected static ?string $model = MineralDescriptivo::class;

         protected static ?string $navigationIcon = 'heroicon-o-fire';

        protected static ?string $cluster = ParametrosGeneralesExplora::class;
        protected static ?string    $navigationLabel = 'Mineral Descriptivo';
        protected static ?string    $navigationGroup = 'Parametros';
        protected static ?string    $navigationParentItem = 'Parametros Generales';
        protected static ?string    $pluralModelLabel = 'Minerales Descriptivos';
        protected static ?string    $slug = '/MineralDescriptivo';

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
            'index' => Pages\ListMineralDescriptivos::route('/'),
            'create' => Pages\CreateMineralDescriptivo::route('/create'),
            'edit' => Pages\EditMineralDescriptivo::route('/{record}/edit'),
        ];
    }
}
