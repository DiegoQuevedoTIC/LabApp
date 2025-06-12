<?php

namespace App\Filament\Operaciones\Resources;

use App\Filament\Operaciones\Resources\PetrografiaMetalogeniaResource\Pages;
use App\Filament\Operaciones\Resources\PetrografiaMetalogeniaResource\RelationManagers;
use App\Models\PetrografiaMetalogenia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetrografiaMetalogeniaResource extends Resource
{
    protected static ?string $model = PetrografiaMetalogeniaResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';




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
            'index' => Pages\ListPetrografiaMetalogenias::route('/'),
            'create' => Pages\CreatePetrografiaMetalogenia::route('/create'),
            'edit' => Pages\EditPetrografiaMetalogenia::route('/{record}/edit'),
        ];
    }
}
