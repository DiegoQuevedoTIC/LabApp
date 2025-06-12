<?php

namespace App\Filament\Operaciones\Resources\PetrografiaMetalogeniaResource\Pages;

use App\Filament\Operaciones\Resources\PetrografiaMetalogeniaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPetrografiaMetalogenias extends ListRecords
{
    protected static string $resource = PetrografiaMetalogeniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
