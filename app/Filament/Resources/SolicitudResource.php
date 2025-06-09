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
                                ->live(),
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
                                ->label('Referencia')
                                ->maxLength(64)
                                ->unique(ignoreRecord: true)
                                ->columnSpan(2),
                        ])->columns(5),
                        Section::make('Origen y Ubicación')
                        ->visible(fn (Get $get): bool => $get('tipo_solicitud') === 'Interna')
                        ->schema([
                            TextInput::make('entidad')
                                ->required(),
                            TextInput::make('direccion_ciudad')
                                ->label('Dirección / Ciudad')
                                ->required(),
                            Select::make('direccion_tecnica_id')
                                ->relationship('direccionTecnica', 'nombre')
                                ->label('Dirección Técnica'),
                            Select::make('grupo_trabajo_id')
                                ->relationship('grupoTrabajo', 'nombre')
                                ->label('Grupo de Trabajo'),
                            Select::make('proyecto_id')
                                ->relationship('proyecto', 'nombre')
                                ->label('Proyecto'),
                                ])
                            ->columns(3),
                        Section::make('Origen y Ubicación')
                        ->visible(fn (Get $get): bool => $get('tipo_solicitud') === 'Externa')
                        ->schema([
                            TextInput::make('entidad')
                                ->label('Entidad Solicitante')
                                ->required(),
                            TextInput::make('direccion_ciudad')
                                ->label('Dirección - Ciudad de Origen')
                                ->columnSpanFull()
                                ->required(),
                                ])
                            ->columns(3)
                    ]),

                Wizard\Step::make('Detalle del Servicio')
                    ->description('Ensayos, muestras y requerimientos específicos.')
                    ->columns(3)
                    ->icon('heroicon-o-beaker')
                    ->schema([
                        Select::make('ensayos')
                            ->relationship('ensayos', 'descripcion')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull()
                            ->label('Ensayos Solicitados')
                            ->label('Ensayos o Actividades Solicitadas'),
                        RichEditor::make('requisitos_especiales')
                            ->columnSpanFull(),
                        TextInput::make('cantidad_muestras_proyectadas')
                            ->numeric()
                            ->label('Cantidad de Muestras Proyectadas')
                            ->columns(1)
                            ->required(),
                        FileUpload::make('soporte')
                            ->disk('public')
                            ->label('Soporte de Solicitud')
                            ->helperText('Adjuntar documentos relevantes para la solicitud.')
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->columnSpanFull()
                            ->directory('soportes-solicitudes')
                            ->openable()
                            ->preserveFilenames(),
                    ]),

                Wizard\Step::make('Contactos')
                    ->description('Personas responsables de la solicitud.')
                    ->icon('heroicon-o-users')
                    ->schema([
                        Grid::make(2)->schema([
                            Section::make('Contacto 1: Reporte de Resultados')
                                ->schema([
                                    Grid::make(2)->schema([
                                        TextInput::make('contacto_1_nombre')->label('Nombre')->required(),
                                        TextInput::make('contacto_1_extension')->label('Teléfono / Extensión'),
                                    ]),
                                    TextInput::make('contacto_1_email')
                                        ->label('Correo Electrónico')
                                        ->email()
                                        ->required(),
                                ]),

                            Section::make('Contacto 2: Entrega de Muestras')
                                ->schema([
                                    Grid::make(2)->schema([
                                        TextInput::make('contacto_2_nombre')->label('Nombre')->required(),
                                        TextInput::make('contacto_2_extension')->label('Teléfono / Extensión'),
                                    ]),
                                    TextInput::make('contacto_2_email')
                                        ->label('Correo Electrónico')
                                        ->email()
                                        ->required(),
                                ]),
                        ])
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
                Tables\Columns\TextColumn::make('entidad')
                    ->label('Entidad Solicitante')
                    ->numeric()
                    ->sortable(),
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
