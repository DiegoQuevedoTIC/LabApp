<?php

namespace App\Filament\Operaciones\Resources;

use App\Filament\Clusters\ParametrosGeneralesExplora;
use App\Filament\Operaciones\Resources\FotografiaAdicionalResource\Pages;
use App\Filament\Operaciones\Resources\FotografiaAdicionalResource\RelationManagers;
use App\Models\FotografiaAdicional;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FotografiaAdicionalResource extends Resource
{
    protected static ?string $model = FotografiaAdicional::class;
     protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

        protected static ?string $cluster = ParametrosGeneralesExplora::class;
        protected static ?string    $navigationLabel = 'FotografiaAdicional';
        protected static ?string    $navigationGroup = 'Parametros';
        protected static ?string    $navigationParentItem = 'Parametros Generales';
        protected static ?string    $pluralModelLabel = 'FotografiaAdicional';
        protected static ?string    $slug = '/FotografiaAdicional';

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
            'index' => Pages\ListFotografiaAdicionals::route('/'),
            'create' => Pages\CreateFotografiaAdicional::route('/create'),
            'edit' => Pages\EditFotografiaAdicional::route('/{record}/edit'),
        ];
    }
}
