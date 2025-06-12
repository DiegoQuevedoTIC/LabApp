<?php

namespace App\Filament\Operaciones\Resources\PetrografiaMetalogeniaResource\Pages;

use App\Filament\Operaciones\Resources\PetrografiaMetalogeniaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPetrografiaMetalogenia extends EditRecord
{
    protected static string $resource = PetrografiaMetalogeniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
