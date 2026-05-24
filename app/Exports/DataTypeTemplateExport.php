<?php

namespace App\Exports;

use App\Models\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DataTypeTemplateExport
{
    protected $dataType;

    public function __construct(DataType $dataType)
    {
        $this->dataType = $dataType;
    }

    public function download()
    {
        $fields = $this->dataType->fields()->orderBy('order')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template ' . $this->dataType->name);

        // Column letters
        $columns = range('A', 'Z');
        if (count($fields) > 26) {
            // Add more columns if needed (AA, AB, etc.)
            for ($i = 0; $i < count($fields) - 26; $i++) {
                $columns[] = 'A' . chr(65 + $i);
            }
        }

        // Set headers
        $headers = [];
        foreach ($fields as $index => $field) {
            $colLetter = $columns[$index];
            $headerLabel = $field->label;
            if ($field->required) {
                $headerLabel .= ' *';
            }
            $headers[] = [
                'label' => $headerLabel,
                'name' => $field->name,
                'type' => $field->type,
                'required' => $field->required,
                'options' => $field->options,
                'colLetter' => $colLetter,
            ];
            $sheet->setCellValue($colLetter . '1', $headerLabel);
        }

        // Style header row
        $lastCol = $columns[count($fields) - 1];
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '166534'], // green-800
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ];
        $sheet->getStyle('A1:' . $lastCol . '1')->applyFromArray($headerStyle);

        // Auto width
        foreach ($columns as $colLetter) {
            if ($colLetter === $lastCol) {
                $sheet->getColumnDimension($colLetter)->setAutoSize(true);
                break;
            }
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Add a second row with field names as comment
        $sheet->setCellValue('A2', 'Baris ini hanya petunjuk, hapus sebelum import');
        $sheet->mergeCells('A2:' . $lastCol . '2');
        $sheet->getStyle('A2')->getFont()->setItalic(true)->getColor()->setARGB('FF999999');

        // Add example row (row 3)
        foreach ($headers as $header) {
            $exampleValue = $this->getExampleValue($header);
            $sheet->setCellValue($header['colLetter'] . '3', $exampleValue);
        }

        // Add dropdown validation for dropdown fields
        foreach ($headers as $header) {
            if ($header['type'] === 'dropdown' && !empty($header['options'])) {
                $options = is_array($header['options']) ? $header['options'] : json_decode($header['options'], true);
                if (is_array($options) && count($options) > 0) {
                    $optionsStr = '"' . implode('","', $options) . '"';
                    for ($row = 3; $row <= 1003; $row++) {
                        $validation = $sheet->getCell($header['colLetter'] . $row)->getDataValidation();
                        $validation->setType(DataValidation::TYPE_LIST);
                        $validation->setFormula1($optionsStr);
                        $validation->setAllowBlank(true);
                        $validation->setShowDropDown(true);
                    }
                }
            }
        }

        // Write to output
        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="template_' . $this->dataType->slug . '.xlsx"');
        $response->headers->set('Cache-Control', 'max-age=0');

        return $response;
    }

    protected function getExampleValue(array $header): string
    {
        $examples = [
            'text' => 'Contoh teks',
            'textarea' => 'Contoh teks panjang',
            'number' => '123',
            'email' => 'contoh@email.com',
            'url' => 'https://contoh.com',
            'date' => date('Y-m-d'),
            'image' => '(upload manual)',
            'file' => '(upload manual)',
        ];

        if ($header['type'] === 'dropdown' && !empty($header['options'])) {
            $options = is_array($header['options']) ? $header['options'] : json_decode($header['options'], true);
            return is_array($options) && count($options) > 0 ? $options[0] : '';
        }

        return $examples[$header['type']] ?? '';
    }
}