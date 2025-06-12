<?php

namespace App\Filament\Operaciones\Resources;

use App\Filament\Clusters\EnsayosAnalisis;
use App\Filament\Operaciones\Resources\PetrografiaResource\Pages;
use App\Filament\Operaciones\Resources\PetrografiaResource\RelationManagers;
use App\Models\Petrografia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetrografiaResource extends Resource
{
    protected static ?string $model = Petrografia::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye-dropper';
    protected static ?string $cluster = EnsayosAnalisis::class;
        protected static ?string    $navigationLabel = 'Petrografia- Metalogenia';
        protected static ?string    $navigationGroup = 'Ensayos Quimicos y Análisis';
        protected static ?string    $navigationParentItem = 'Ensayos y Análisis';
        protected static ?string    $pluralModelLabel = 'Petrografia- Metalogenia';
        protected static ?string    $slug = '/PetrografiaMetalogenia';


public static function form(Form $form): Form
{
    return $form->schema([
        Tabs::make('Formulario de Petrografía')->tabs([

            // ==================== PESTAÑA 1: INFORMACIÓN GENERAL ====================
            Tabs\Tab::make('1. Información General')->schema([
                Grid::make(3)->schema([
                    TextInput::make('id_muestra')->required()->columnSpan(1),
                    DatePicker::make('fecha_muestreo')->required()->columnSpan(1),
                    TextInput::make('colector')->columnSpan(1),
                    TextInput::make('longitud')->numeric()->required()->columnSpan(1),
                    TextInput::make('latitud')->numeric()->required()->columnSpan(1),
                    TextInput::make('altura')->label('Altura (m)')->numeric()->required()->columnSpan(1),
                    Select::make('sistema_coordenadas')->options(['WGS-84' => 'WGS-84', 'SIRGAS' => 'SIRGAS'])->required()->columnSpan(1),
                    Select::make('plancha')->options(['Plancha A' => 'Plancha A', 'Plancha B' => 'Plancha B'])->columnSpan(1),
                    TextInput::make('proyecto')->columnSpan(1),
                    TextInput::make('departamento')->columnSpan(1),
                    TextInput::make('municipio')->columnSpan(1),
                    TextInput::make('vereda')->columnSpan(1),
                    TextInput::make('cuenca')->columnSpan(1),
                    TextInput::make('cuenca_principal')->columnSpan(1),
                    TextInput::make('analizador')->columnSpan(1),
                    TextInput::make('laboratorio_preparacion')->columnSpan(1),
                    TextInput::make('tipo_preparacion')->columnSpan(1),
                    DatePicker::make('fecha_analisis')->columnSpan(1),
                ]),
            ]),

            // ==================== PESTAÑA 2: DESCRIPCIÓN DE CAMPO ====================
            Tabs\Tab::make('2. Descripción de Campo')->schema([
                Textarea::make('rodados')->rows(5),
                Textarea::make('afloramientos')->rows(5),
                FileUpload::make('fotografia_general_seccion')->image()->directory('secciones'),
            ]),

            // ==================== PESTAÑA 3: DESCRIPCIÓN PETROGRÁFICA ====================
            Tabs\Tab::make('3. Descripción Petrográfica')->schema([
                Textarea::make('descripcion_petrografica_general')->label('Descripción General')->rows(5),
                Section::make('Minerales Opacos')->schema([
                    Repeater::make('mineralesOpacos')->relationship()->schema([
                        TextInput::make('mineral')->required(),
                        TextInput::make('porcentaje')->numeric()->suffix('%')->required(),
                        TextInput::make('tamano_promedio')->label('Tamaño Promedio (mm)')->numeric()->required(),
                        TextInput::make('forma')->label('Forma (Sistema y Grado Cristalinidad)')->required(),
                        Textarea::make('descripcion'),
                    ])->columns(5),
                ]),
                Section::make('Minerales Translúcidos')->schema([
                    Repeater::make('mineralesTranslucidos')->relationship()->schema([
                        TextInput::make('mineral')->required(),
                        TextInput::make('porcentaje')->numeric()->suffix('%')->required(),
                        TextInput::make('tamano_promedio')->label('Tamaño Promedio (mm)')->numeric()->required(),
                        TextInput::make('forma')->label('Forma (Sistema y Grado Cristalinidad)')->required(),
                        Textarea::make('descripcion'),
                    ])->columns(5),
                ]),
            ]),

            // ==================== PESTAÑA 4: CONTEO DE PUNTOS ====================
            Tabs\Tab::make('4. Conteo')->schema([
                // --- CAMPOS DE CONTEO ---
                Section::make('Cristales Contados')->description('Ingrese el número de puntos contados para cada componente.')
                ->collapsible()->columns(6)->schema([
                    // Se agregan todos los 35 campos de conteo...
                    TextInput::make('conteo_qmon')->label('Qmon')->numeric()->live(onBlur: true)->default(0),
                    TextInput::make('conteo_qpol')->label('Qpol')->numeric()->live(onBlur: true)->default(0),
                    TextInput::make('conteo_qpf')->label('Qpf')->numeric()->live(onBlur: true)->default(0),
                    TextInput::make('conteo_qmons')->label('Qmons')->numeric()->live(onBlur: true)->default(0),
                    TextInput::make('conteo_f_plag')->label('F-Plag')->numeric()->live(onBlur: true)->default(0),
                    TextInput::make('conteo_f_kfelds')->label('F-K-felds')->numeric()->live(onBlur: true)->default(0),
                    // ... (agrega aquí todos los 35 campos de la misma manera)
                    TextInput::make('conteo_cmx')->label('CMx')->numeric()->live(onBlur: true)->default(0),
                    TextInput::make('conteo_ccm')->label('CCm')->numeric()->live(onBlur: true)->default(0),
                    TextInput::make('conteo_armx')->label('ArMx')->numeric()->live(onBlur: true)->default(0),
                ]),
                // --- CÁLCULOS Y RESULTADOS ---
                Section::make('Resultados del Conteo')->columns(3)->schema([
                    Placeholder::make('total_puntos')
                        ->label('Total Puntos Contados')
                        ->content(function (Get $get): string {
                            $total = 0;
                            // Recorre todos los campos de conteo y súmalos
                            foreach ($get() as $key => $value) {
                                if (str_starts_with($key, 'conteo_')) {
                                    $total += (int)$value;
                                }
                            }
                            $color = $total < 300 ? 'text-danger-500' : 'text-success-500';
                            return "<span class='text-xl font-bold {$color}'>{$total}</span>";
                        })->helperText('Debe ser >= 300'),

                    Placeholder::make('porcentaje_qfl')
                        ->label('% Q-F-L Normalizado')
                        ->content(function (Get $get): string {
                            $Q = (int)$get('conteo_qmon') + (int)$get('conteo_qpol') + (int)$get('conteo_qpf') + (int)$get('conteo_qmons');
                            $F = (int)$get('conteo_f_plag') + (int)$get('conteo_f_kfelds');
                            $L = (int)$get('conteo_lm') + (int)$get('conteo_lp') + (int)$get('conteo_lvf') + (int)$get('conteo_lvm') + (int)$get('conteo_lvl') + (int)$get('conteo_lvv') + (int)$get('conteo_lss') + (int)$get('conteo_lscm') + (int)$get('conteo_lssm') + (int)$get('conteo_lsch') + (int)$get('conteo_lsl');
                            $total = $Q + $F + $L;
                            if ($total == 0) return 'Q: 0% F: 0% L: 0%';
                            $pQ = round(($Q / $total) * 100, 1);
                            $pF = round(($F / $total) * 100, 1);
                            $pL = round(($L / $total) * 100, 1);
                            return "<span class='font-bold'>Q: {$pQ}% F: {$pF}% L: {$pL}%</span>";
                        }),

                    Placeholder::make('porcentaje_lvlmls')
                        ->label('% Lv-Lm-Ls Normalizado')
                        ->content(function (Get $get): string {
                            $Lv = (int)$get('conteo_lvf') + (int)$get('conteo_lvm') + (int)$get('conteo_lvl') + (int)$get('conteo_lvv');
                            $Lm = (int)$get('conteo_lm'); // Asumiendo Lm y Lp son metamórficos
                            $Ls = (int)$get('conteo_lss') + (int)$get('conteo_lscm') + (int)$get('conteo_lssm') + (int)$get('conteo_lsch') + (int)$get('conteo_lsl');
                            $total = $Lv + $Lm + $Ls;
                             if ($total == 0) return 'Lv: 0% Lm: 0% Ls: 0%';
                            $pLv = round(($Lv / $total) * 100, 1);
                            $pLm = round(($Lm / $total) * 100, 1);
                            $pLs = round(($Ls / $total) * 100, 1);
                            return "<span class='font-bold'>Lv: {$pLv}% Lm: {$pLm}% Ls: {$pLs}%</span>";
                        }),
                ]),
            ]),

            // ==================== PESTAÑA 5: MINERALES DE INTERÉS ====================
            Tabs\Tab::make('5. Minerales de Interés')->schema([
                Repeater::make('mineralesInteres')->relationship()->schema([
                    TextInput::make('mineral')->required(),
                    TextInput::make('numero_cristal')->numeric()->required(),
                    TextInput::make('largo')->numeric()->required(),
                    TextInput::make('ancho')->numeric()->required(),
                    TextInput::make('geometria')->required(),
                    Textarea::make('observaciones')->columnSpan(2),
                    FileUpload::make('foto1')->image()->directory('minerales'),
                    FileUpload::make('foto2')->image()->directory('minerales'),
                ])->columns(4),
            ]),

            // ==================== PESTAÑA 6: FOTOGRAFÍAS ====================
            Tabs\Tab::make('6. Fotografías')->schema([
                Repeater::make('fotografiasAdicionales')->relationship()->schema([
                    FileUpload::make('imagen')->required()->image()->directory('fotografias'),
                    Textarea::make('descripcion'),
                ])->columns(1),
            ]),

        ])->columnSpanFull()
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPetrografias::route('/'),
            'create' => Pages\CreatePetrografia::route('/create'),
            'edit' => Pages\EditPetrografia::route('/{record}/edit'),
        ];
    }
}
