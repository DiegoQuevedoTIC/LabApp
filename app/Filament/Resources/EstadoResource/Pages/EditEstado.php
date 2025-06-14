<?php

namespace App\Filament\Resources\EstadoResource\Pages;

use App\Filament\Resources\EstadoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEstado extends EditRecord
{
    protected static string $resource = EstadoResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

            protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
