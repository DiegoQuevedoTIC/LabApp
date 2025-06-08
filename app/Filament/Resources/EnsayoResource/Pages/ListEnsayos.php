<?php

namespace App\Filament\Resources\EnsayoResource\Pages;

use App\Filament\Resources\EnsayoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnsayos extends ListRecords
{
    protected static string $resource = EnsayoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
