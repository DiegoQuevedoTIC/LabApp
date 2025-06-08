<?php

namespace App\Filament\Resources\GrupoTrabajoResource\Pages;

use App\Filament\Resources\GrupoTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrupoTrabajos extends ListRecords
{
    protected static string $resource = GrupoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
