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
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Model;
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
            Section::make('Identificador único, fecha inicial y estado actual de la solicitud.')
                ->icon('heroicon-o-bookmark-square')
                ->schema([
                    Grid::make(5)->schema([
                            TextInput::make('id')
                                ->prefix('SOL-')
                                ->label('ID de Solicitud') // Es mejor poner el label aquí
                                ->readOnly() // 2. Usa readOnly para que el valor sea visible pero no editable
                                ->extraInputAttributes(['style' => 'text-align: center;  background-color: teal; color: white; font-weight: bold;'])
                                ->prefixIcon('heroicon-o-key')
                                ->prefixIconColor('success')
                                ->helperText('ID único de la solicitud.'),
                            Select::make('estado_id')
                                ->columnSpan(2)
                                ->disabled()
                                ->relationship('estado', 'nombre')
                                ->hint('Estado de la Solicitud')
                                ->hintColor('primary')
                                ->default(fn () => Estado::where('nombre', 'En revisión')->first()?->id)
                                ->required()
                                ->label(' ')
                                ->helperText('Estado actual de la solictud.'),
                            DatePicker::make('fecha_solicitud')
                                ->default(now())
                                ->required()
                                ->hint('Fecha de Solicitud')
                                ->required()

                                ->hintColor('primary')
                                ->columnSpan(2)
                                ->disabled(fn (string $operation): bool =>  $operation === 'edit')
                                ->label(' ')
                                ->helperText('Fecha en que se registra el inicio de  la solicitud.'),
                    ])
                ]),
            Wizard::make([
                Wizard\Step::make('Datos Generales y Procedencia')
                    ->description('Información principal y origen de la solicitud.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                            ToggleButtons::make('tipo_solicitud')
                                ->label('Tipo de Solicitud')
                                ->options([
                                    'Interna' => 'Interna',
                                    'Externa' => 'Externa',
                                ])

                                ->default('Interna')
                                ->helperText('Seleccione el tipo de solicitud.')
                                ->inline()
                                ->live(),
                        Section::make('Origen y Ubicación')
                        ->visible(fn (Get $get): bool => $get('tipo_solicitud') === 'Interna')
                        ->schema([
                            Select::make('direccion_tecnica_id')
                                ->relationship('direccionTecnica', 'nombre')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Por favor, selecciona una dirección técnica.',
                                ])
                                ->label('Dirección Técnica'),
                            Select::make('grupo_trabajo_id')
                                ->relationship('grupoTrabajo', 'nombre')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Por favor, selecciona un grupo de trabajo.',
                                ])
                                ->label('Grupo de Trabajo'),
                            Select::make('proyecto_id')
                                ->relationship('proyecto', 'nombre')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Por favor, selecciona un proyecto.',
                                ])
                                ->label('Proyecto'),
                                ])
                            ->columns(3),
                        Section::make('Origen y Ubicación')
                        ->visible(fn (Get $get): bool => $get('tipo_solicitud') === 'Externa')
                        ->schema([
                            TextInput::make('referencia')
                                ->required()
                                ->label('Radicado de Solicitud')
                                ->maxLength(64)
                                ->validationMessages([
                                        'required' => 'Por favor, ingresa el codigo del radicado con que se recibio la solicitud.',
                                    ])
                                ->unique(ignoreRecord: true)
                                ->columnSpan(1),
                            TextInput::make('entidad')
                                ->label('Entidad Solicitante')
                                ->columnSpan(1)
                                ->validationMessages([
                                        'required' => 'Por favor, ingresa el nombre de la entidad que hace la solicitud.',
                                    ])
                                ->required(),
                            TextInput::make('direccion_ciudad')
                                ->label('Dirección - Ciudad de Origen')
                                ->columnSpan(1)
                                ->validationMessages([
                                    'required' => 'Por favor, ingresa la dirección y ciudad de origen de la solicitud.',
                                ])
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
                            ->required()
                            ->validationMessages([
                                'required' => 'Es necesario incluir por lo menos un ensayo.',
                                    ])
                            ->columnSpanFull()
                            ->label('Ensayos o Actividades Solicitadas'),
                        RichEditor::make('requisitos_especiales')
                            ->label('Requisitos Especiales')
                            ->required()
                            ->validationMessages([
                                'required' => 'Por favor, especifica los requisitos especiales o condiciones para los ensayos.',
                            ])
                            ->placeholder('Especificar requisitos especiales, condiciones o especificaciones para los ensayos.')
                            ->columnSpanFull(),
                        TextInput::make('cantidad_muestras_proyectadas')
                            ->numeric()
                            ->label('Cantidad de Muestras Proyectadas')
                            ->required()
                            ->validationMessages([
                                'required' => 'Ingresa la cantidad de muestras proyectadas.',
                            ])
                            ->columns(1),
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
                        Grid::make(6)->schema([
                                        TextInput::make('contacto_1_nombre')
                                            ->label('Nombre')
                                            ->required()
                                            ->hint('Se necesita por lo menos registrar un contacto.')
                                            ->validationMessages([
                                            'required' => 'Por favor, ingresa el nombre del contacto para el reporte de resultados.',
                                            ])
                                            ->columnSpan(3),
                                        TextInput::make('contacto_1_extension')
                                            ->columnSpan(1)
                                            ->required()
                                            ->validationMessages([
                                                'required' => 'Ingresa el teléfono.',
                                            ])
                                            ->label('Teléfono'),
                                        TextInput::make('contacto_1_email')
                                            ->label('Correo Electrónico')
                                            ->email()
                                            ->columnSpan(2)
                                            ->validationMessages([
                                                'required' => 'Ingresa el mail del contacto para la gestion de la solicitud.',
                                            ])
                                            ->required(),
                                        TextInput::make('contacto_2_nombre')
                                            ->label('Nombre')
                                            ->columnSpan(3),
                                        TextInput::make('contacto_2_extension')
                                        ->label('Teléfono / Extensión')
                                        ->columnSpan(1),
                                    TextInput::make('contacto_2_email')
                                        ->label('Correo Electrónico')
                                        ->columnSpan(2)
                                        ->email()


                        ])
                    ]),
            ])->columnSpanFull(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID ')
                    ->formatStateUsing(fn (string $state): string => "SOL-" . str_pad($state, 0, '0', STR_PAD_LEFT))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo_solicitud')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_solicitud')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ensayos.descripcion')
                    ->label('Ensayos Solicitados')
                    ->listWithLineBreaks()
                    ->badge()
                    ->limit(80)
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MuestrasRelationManager::class,
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
