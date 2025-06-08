<?php

namespace App\Filament\Resources\ClaseEnsayoResource\Pages;

use App\Filament\Resources\ClaseEnsayoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClaseEnsayo extends EditRecord
{
    protected static string $resource = ClaseEnsayoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
