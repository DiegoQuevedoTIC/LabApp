<?php

namespace App\Filament\Operaciones\Resources\MineralDescriptivoResource\Pages;

use App\Filament\Operaciones\Resources\MineralDescriptivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMineralDescriptivos extends ListRecords
{
    protected static string $resource = MineralDescriptivoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
