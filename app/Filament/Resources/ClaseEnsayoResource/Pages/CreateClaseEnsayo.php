<?php

namespace App\Filament\Resources\ClaseEnsayoResource\Pages;

use App\Filament\Resources\ClaseEnsayoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateClaseEnsayo extends CreateRecord
{
    protected static string $resource = ClaseEnsayoResource::class;

            protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
