<?php

namespace App\Filament\Resources\EnsayoResource\Pages;

use App\Filament\Resources\EnsayoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnsayo extends EditRecord
{
    protected static string $resource = EnsayoResource::class;

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
