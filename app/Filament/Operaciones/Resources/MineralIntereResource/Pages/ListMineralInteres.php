<?php

namespace App\Filament\Operaciones\Resources\MineralIntereResource\Pages;

use App\Filament\Operaciones\Resources\MineralIntereResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMineralInteres extends ListRecords
{
    protected static string $resource = MineralIntereResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
