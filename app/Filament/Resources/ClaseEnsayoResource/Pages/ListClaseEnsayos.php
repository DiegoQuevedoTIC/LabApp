<?php

namespace App\Filament\Resources\ClaseEnsayoResource\Pages;

use App\Filament\Resources\ClaseEnsayoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClaseEnsayos extends ListRecords
{
    protected static string $resource = ClaseEnsayoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
