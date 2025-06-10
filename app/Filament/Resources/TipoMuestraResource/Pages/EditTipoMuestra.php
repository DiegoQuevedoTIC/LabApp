<?php

namespace App\Filament\Resources\TipoMuestraResource\Pages;

use App\Filament\Resources\TipoMuestraResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTipoMuestra extends EditRecord
{
    protected static string $resource = TipoMuestraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
