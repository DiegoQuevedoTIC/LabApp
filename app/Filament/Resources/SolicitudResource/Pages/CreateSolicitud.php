<?php

namespace App\Filament\Resources\SolicitudResource\Pages;

use App\Filament\Resources\SolicitudResource;
use Filament\Actions\CreateAction;
use Filament\Actions\CancelAction;
use Filament\Resources\Pages\CreateRecord;

class CreateSolicitud extends CreateRecord
{
    protected static string $resource = SolicitudResource::class;

        protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }



}
