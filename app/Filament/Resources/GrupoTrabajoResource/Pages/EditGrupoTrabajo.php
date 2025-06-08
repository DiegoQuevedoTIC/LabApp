<?php

namespace App\Filament\Resources\GrupoTrabajoResource\Pages;

use App\Filament\Resources\GrupoTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGrupoTrabajo extends EditRecord
{
    protected static string $resource = GrupoTrabajoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ///Actions\DeleteAction::make(),
        ];
    }
}
