<?php

namespace App\Filament\Operaciones\Resources\PetrografiaResource\Pages;

use App\Filament\Operaciones\Resources\PetrografiaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPetrografias extends ListRecords
{
    protected static string $resource = PetrografiaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
