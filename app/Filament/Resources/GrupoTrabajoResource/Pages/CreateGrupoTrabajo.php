<?php

namespace App\Filament\Resources\GrupoTrabajoResource\Pages;

use App\Filament\Resources\GrupoTrabajoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGrupoTrabajo extends CreateRecord
{
    protected static string $resource = GrupoTrabajoResource::class;

            protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

}
