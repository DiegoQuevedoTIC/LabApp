<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitudResource\Pages;
use App\Filament\Resources\SolicitudResource\RelationManagers;
use App\Models\Solicitud;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use App\Models\Estado;
use Filament\Forms\Get;

class SolicitudResource extends Resource
{
    protected static ?string $model = Solicitud::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';


        protected static ?string    $navigationLabel = 'Solicitudes';
        protected static ?string    $pluralModelLabel = 'Solicitudes';
        protected static ?string    $slug = '/Solicitudes';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Wizard::make([
                // --- PASO 1 y 2 FUSIONADOS AQUÍ ---
                Wizard\Step::make('Datos Generales y Procedencia')
                    ->description('Información principal y origen de la solicitud.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        // Sección con los datos del paso 1 original
                        Section::make('Información de la Solicitud')->schema([
                            ToggleButtons::make('tipo_solicitud')
                                ->label('Tipo de Solicitud')
                                ->options([
                                    'Interna' => 'Interna',
                                    'Externa' => 'Externa',
                                ])
                                ->required()
                                ->inline()
                                ->live(), // <-- Sigue siendo crucial para la lógica condicional

                            DatePicker::make('fecha_solicitud')
                                ->default(now())
                                ->required(),

                            Select::make('estado_id')
                                ->relationship('estado', 'nombre')
                                ->label('Estado de la Solicitud')
                                ->default(fn () => Estado::where('nombre', 'Solicitada')->first()?->id)
                                ->disabled(fn (string $operation): bool => $operation === 'create')
                                ->dehydrated()
                                ->required(),

                            TextInput::make('referencia')
                                ->required()
                                ->maxLength(16),
                        ])->columns(2),

                        // Sección con los datos del paso 2 original
                        Section::make('Origen y Ubicación')->schema([
                            TextInput::make('entidad')->required(),
                            TextInput::make('direccion_ciudad')->label('Dirección / Ciudad')->required(),
                        ])->columns(2),

                        // La sección condicional se mantiene igual y funcionará perfectamente
                        Section::make('Detalles Internos')
                            ->description('Esta sección solo aplica para solicitudes internas.')
                            ->visible(fn (Get $get): bool => $get('tipo_solicitud') === 'interna')
                            ->schema([
                                Select::make('direccion_tecnica_id')
                                    ->relationship('direccionTecnica', 'nombre')
                                    ->label('Dirección Técnica'),

                                Select::make('grupo_trabajo_id')
                                    ->relationship('grupoTrabajo', 'nombre')
                                    ->label('Grupo de Trabajo'),

                                Select::make('proyecto_id')
                                    ->relationship('proyecto', 'nombre')
                                    ->label('Proyecto'),
                            ])->columns(3),
                    ]),

                // Los pasos 3 y 4 originales ahora son los pasos 2 y 3
                Wizard\Step::make('Contactos')
                    ->description('Personas responsables de la solicitud.')
                    ->icon('heroicon-o-users')
                    ->schema([
                        Grid::make(2)->schema([
                            Section::make('Contacto 1: Reporte de Resultados')
                                ->schema([
                                    TextInput::make('contacto_1_nombre')->required(),
                                    TextInput::make('contacto_1_email')->email()->required(),
                                    TextInput::make('contacto_1_extension')->label('Telefono / Extensión'),
                                ]),
                            Section::make('Contacto 2: Entrega de Muestras')
                                ->schema([
                                    TextInput::make('contacto_2_nombre')->required(),
                                    TextInput::make('contacto_2_email')->email()->required(),
                                    TextInput::make('contacto_2_extension')->label('Telefono / Extensión'),
                                ]),
                        ])
                    ]),

                Wizard\Step::make('Detalle del Servicio')
                    ->description('Ensayos, muestras y requerimientos específicos.')
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Select::make('ensayos')
                            ->relationship('ensayos', 'descripcion')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Ensayos o Actividades Solicitadas'),

                        RichEditor::make('requisitos_especiales')->columnSpanFull(),

                        TextInput::make('cantidad_muestras_proyectadas')->numeric()->required(),

                        FileUpload::make('soporte')
                            ->disk('public')
                            ->directory('soportes-solicitudes')
                            ->openable()
                            ->preserveFilenames(),
                    ]),
            ])->columnSpanFull(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('referencia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo_solicitud')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_solicitud')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('direcciontecnica.nombre')
                    ->label('Dirección Técnica')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grupotrabajo.nombre')
                    ->label('Grupo de Trabajo')
                    ->numeric()
                    ->sortable(),
//                Tables\Columns\TextColumn::make('proyecto.nombre')
//                    ->label('Proyecto')
//                    ->numeric()
//                    ->sortable(),

                Tables\Columns\TextColumn::make('cantidad_muestras_proyectadas')
                    ->numeric()
                    ->label('Muestras Proyectadas')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolicituds::route('/'),
            'create' => Pages\CreateSolicitud::route('/create'),
            'edit' => Pages\EditSolicitud::route('/{record}/edit'),
        ];
    }
}
