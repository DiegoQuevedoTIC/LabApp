<?php

namespace App\Filament\Operaciones\Resources\FotografiaAdicionalResource\Pages;

use App\Filament\Operaciones\Resources\FotografiaAdicionalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFotografiaAdicionals extends ListRecords
{
    protected static string $resource = FotografiaAdicionalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
