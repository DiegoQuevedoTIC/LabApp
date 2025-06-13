<?php

namespace App\Filament\Resources\SolicitudResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use App\Filament\Imports\MuestraImporter;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use App\Exports\MuestraProformaExport;
use App\Models\Solicitud;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Maatwebsite\Excel\Facades\Excel;

class MuestrasRelationManager extends RelationManager
{
    protected static string $relationship = 'muestras';

    public function form(Form $form): Form
    {

return $form
    ->schema([
            TextInput::make('codigo_consecutivo')
                ->label('Código Consecutivo')
                ->required()
                ->maxLength(255)
                ->default(1)
                ->hidden(),
            TextInput::make('consecutivo')
                ->numeric()
                ->label('Consecutivo Interno')
                ->required()
                ->default(1)
                ->hidden(),
            TextInput::make('referencia_campo')
            ->required()
            ->maxLength(30)
            ->extraInputAttributes(['style' => 'text-align: center;  background-color: teal; color: white; font-weight: bold;'])
            ->prefixIcon('heroicon-o-key')
            ->prefixIconColor('success')
            ->placeholder('Ingrese Cod. Referencia de Campo')
            ->helperText('Identificacion Unica de la muestra en campo.')
            ->validationMessages([
                'required' => 'Ingresa el mail del contacto para la gestion de la solicitud.',
                            'max' => 'La referencia de campo no puede exceder los 30 caracteres.',
                             ])
                ->label('Referencia de Campo'),
        Select::make('tipo_muestra_id')
            ->label('Tipo de Muestra')
            ->relationship('tipoMuestra', 'nombre')
            ->required()
            ->searchable()
            ->reactive()
            ->live()
            ->preload(),
            TextInput::make('localizacion_geografica')
                ->label('Localización Geográfica'),
            TextInput::make('descripcion_preliminar')
                ->columnSpanFull()
                ->label('Descripción Preliminar'),
            Textarea::make('observaciones')
                ->label('Observaciones')
                ->rows(3)
                ->columnSpanFull(),


        Grid::make(4)->schema([
            TextInput::make('ph')
                ->label('pH')
                ->numeric()
                ->step(0.01),
            TextInput::make('temperatura')
                ->label('Temperatura (°C)')
                ->numeric()
                ->step(0.01),
            TextInput::make('conductividad')
                ->label('Conductividad (μS/cm)')
                ->numeric()
                ->step(0.01),
            TextInput::make('alcalinidad')
                ->label('Alcalinidad (mg/L)')
                ->numeric()
                ->step(0.01),
        ]),
        Grid::make(3)->schema([
            Select::make('origen')
                ->options([
                    'UGS84' => 'UGS84',
                    'bogota' => 'Origen Bogota',
                    'uniconacional' => 'Origen Unico Nacional',
                    'geograficas' => 'Geograficas',
                ])
                ->label('Origen'),
            TextInput::make('norte')
                ->label('Coordenada Norte')
                ->numeric()
                ->step(0.000001),
            TextInput::make('este')
                ->label('Coordenada Este')
                ->numeric()
                ->step(0.000001),
        ]),
        Grid::make(3)->schema([
            Toggle::make('criterio_1')
                ->label('Muestra Identificable?'),
            Toggle::make('criterio_2')
                ->label('Embalaje Adecuado?'),
            Toggle::make('criterio_3')
                ->label('Cantidad Minima Requerida?'),
        ]),

        Grid::make(1)->schema([
            Toggle::make('criterio_4')
                ->label('Cadena de Frio para muestras de Agua?')
                ->visible(fn (Get $get) => $get('tipo_muestra_id') == 4),
        ]),
    ]);

}





    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('codigo_consecutivo')
            ->columns([
                Tables\Columns\TextColumn::make('consecutivo'),
                Tables\Columns\TextColumn::make('codigo_consecutivo')->searchable(),
                Tables\Columns\TextColumn::make('referencia_campo'),
                Tables\Columns\ToggleColumn::make('criterio_1')
                    ->disabled(true)
                    ->label('Identificable?'),
                Tables\Columns\ToggleColumn::make('criterio_2')
                    ->disabled(true)
                    ->label('Embalaje?'),
                Tables\Columns\ToggleColumn::make('criterio_3')
                    ->disabled(true)
                    ->label('Cantidad ?'),
                Tables\Columns\TextColumn::make('tipoMuestra.nombre')
                    ->label('Tipo de Muestra')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
        ->headerActions([
            CreateAction::make(),
            ActionGroup::make([
            Action::make('descargar_proforma')
                ->label('Descargar Proforma')
                ->icon('heroicon-o-document-arrow-down')
                ->action(fn () => Excel::download(new MuestraProformaExport, 'proforma_muestras.xlsx')),
            ImportAction::make()
                ->label('Cargar Archivo')
                ->importer(MuestraImporter::class)
                ->color('primary')
                ->options(['solicitud_id' => $this->ownerRecord->id]),
        ])
        ->label('Importación Masiva')
        ->icon('heroicon-o-arrow-up-tray')
        ->color('secondary')
        ->button(),
        ])


            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
