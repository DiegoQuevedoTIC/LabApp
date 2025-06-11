<?php

namespace App\Filament\Imports;

use App\Models\Muestra;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class MuestraImporter extends Importer
{
    protected static ?string $model = Muestra::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('solicitud')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('consecutivo')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('codigo_consecutivo')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('referencia_campo')
                ->rules(['max:255']),
            ImportColumn::make('tipoMuestra')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('localizacion_geografica'),
            ImportColumn::make('descripcion_preliminar'),
            ImportColumn::make('origen'),
            ImportColumn::make('observaciones'),
            ImportColumn::make('ph')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('temperatura')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('conductividad')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('alcalinidad')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('norte')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('este')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('criterio_1')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('criterio_2')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('criterio_3')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): ?Muestra
    {
        // return Muestra::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Muestra();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your muestra import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
