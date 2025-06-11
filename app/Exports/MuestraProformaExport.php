<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MuestraProformaExport implements FromCollection, WithHeadings, WithEvents, WithStyles, WithColumnWidths
{

        public function collection()
    {
        return collect([]);
    }
    /**
     * Define the headings for the export.
     *
     * @return array
     */


    public function headings(): array
    {

        return [
            'ID Referencia en Campo',
            'Tipo de Muestra',
            'Localización Geográfica',
            'Descripción Preliminar de la Muestra',
            'Origen de la Muestra',
            'Observaciones Generales',
            'pH (ej: 7.5)',
            'Temperatura (°C)',
            'Conductividad (μS/cm)',
            'Alcalinidad (mg/L)',
            'Coordenada Norte',
            'Coordenada Este',
            '¿Identificable?' ,
            '¿Embalaje Correcto?',
            '¿Cantidad Suficiente?',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E5E7EB'], // Gris claro (Tailwind gray-200)
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22,
            'B' => 15,
            'C' => 22,
            'D' => 34,
            'E' => 19,
            'F' => 24,
            'G' => 10,
            'H' => 16,
            'I' => 21,
            'J' => 17,
            'K' => 17,
            'L' => 17,
            'M' => 17,
            'N' => 19,
            'O' => 20,
        ];
    }

      public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();


                $comments = [
                    'A1' => 'ID único para referencia en campo',
                    'B1' => 'Valores esperados: Agua, Suelo, Roca',
                    'C1' => 'Descripción de la ubicación geográfica',
                    'D1' => 'Descripción preliminar de la muestra',
                    'E1' => 'Origen de la muestra (ej: río, lago, etc.)',
                    'F1' => 'Observaciones generales sobre la muestra',
                    'G1' => 'Valor del pH de la muestra (ej: 7.5)',
                    'H1' => 'Temperatura de la muestra en grados Celsius',
                    'I1' => 'Conductividad de la muestra en microSiemens por centímetro (μS/cm)',
                    'J1' => 'Alcalinidad de la muestra en miligramos por litro (mg/L)',
                    'K1' => 'Coordenada Norte de la ubicación de la muestra-Origen Unico',
                    'L1' => 'Coordenada Este de la ubicación de la muestra-Origen Unico',
                    'M1' => 'Sí o No',
                    'N1' => 'Sí o No',
                    'O1' => 'Sí o No',
                ];

                foreach ($comments as $cell => $note) {
                    $sheet->getComment($cell)
                        ->getText()->createTextRun($note);
                    $sheet->getComment($cell)
                        ->setWidth('200pt')->setHeight('40pt');
                }



                // Ajuste de altura para encabezado
                $sheet->getRowDimension(2)->setRowHeight(30);
            },
        ];
    }

}
