<?php

namespace App\Filament\Resources\TipoMuestraResource\Pages;

use App\Filament\Resources\TipoMuestraResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTipoMuestras extends ListRecords
{
    protected static string $resource = TipoMuestraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
