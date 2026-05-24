<?php

namespace App\Imports;

use App\Models\DataField;
use App\Models\DataRecord;
use App\Models\DataRecordValue;
use App\Models\DataType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DataTypeImport
{
    protected $dataType;
    protected $fields;
    protected $errors = [];
    protected $imported = 0;

    public function __construct(DataType $dataType)
    {
        $this->dataType = $dataType;
        $this->fields = $dataType->fields()->orderBy('order')->get();
    }

    public function import($file)
    {
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        if (empty($rows) || count($rows) < 2) {
            $this->errors[] = 'File Excel kosong atau tidak memiliki data.';
            return [
                'success' => false,
                'imported' => 0,
                'errors' => $this->errors,
            ];
        }

        // Get header row (row 1)
        $headers = $rows[0];
        // Skip row 2 if it's the instruction row
        $dataStartRow = 1;
        if (isset($rows[1]) && !empty($rows[1][0]) && strpos($rows[1][0], 'Baris ini hanya petunjuk') !== false) {
            $dataStartRow = 2;
        }

        // Map headers to fields
        $fieldMap = [];
        foreach ($headers as $colIndex => $header) {
            $header = trim($header);
            // Remove trailing asterisk for required indicator
            $cleanHeader = rtrim($header, ' *');
            
            $field = $this->fields->first(function ($f) use ($cleanHeader) {
                return strtolower($f->label) === strtolower($cleanHeader);
            });

            if ($field) {
                $fieldMap[$colIndex] = $field;
            }
        }

        if (empty($fieldMap)) {
            $this->errors[] = 'Header tidak cocok dengan field yang ada. Pastikan header sesuai dengan template.';
            return [
                'success' => false,
                'imported' => 0,
                'errors' => $this->errors,
            ];
        }

        // Process data rows
        for ($i = $dataStartRow; $i < count($rows); $i++) {
            $row = $rows[$i];
            
            // Skip empty rows
            if (empty(array_filter($row, function ($val) {
                return $val !== null && trim($val) !== '';
            }))) {
                continue;
            }

            $rowErrors = [];
            $values = [];

            foreach ($fieldMap as $colIndex => $field) {
                $rawValue = $row[$colIndex] ?? '';
                
                // Convert Excel date serial to date string
                if ($field->type === 'date' && is_numeric($rawValue) && $rawValue > 1) {
                    try {
                        $rawValue = Date::excelToDateTimeObject($rawValue)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Keep original value
                    }
                }

                $value = trim((string) $rawValue);

                // Validate required
                if ($field->required && empty($value)) {
                    $rowErrors[] = "Baris " . ($i + 1) . ": {$field->label} wajib diisi.";
                    continue;
                }

                // Validate dropdown options
                if ($field->type === 'dropdown' && !empty($value)) {
                    $options = is_array($field->options) ? $field->options : json_decode($field->options, true) ?? [];
                    if (!in_array($value, $options)) {
                        $rowErrors[] = "Baris " . ($i + 1) . ": {$field->label} berisi nilai '{$value}' yang tidak valid. Pilihan: " . implode(', ', $options);
                        continue;
                    }
                }

                // Validate email
                if ($field->type === 'email' && !empty($value)) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $rowErrors[] = "Baris " . ($i + 1) . ": {$field->label} bukan email yang valid.";
                        continue;
                    }
                }

                // Validate URL
                if ($field->type === 'url' && !empty($value)) {
                    if (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $rowErrors[] = "Baris " . ($i + 1) . ": {$field->label} bukan URL yang valid.";
                        continue;
                    }
                }

                // Validate number
                if ($field->type === 'number' && !empty($value)) {
                    if (!is_numeric($value)) {
                        $rowErrors[] = "Baris " . ($i + 1) . ": {$field->label} harus berupa angka.";
                        continue;
                    }
                }

                $values[$field->id] = $value;
            }

            if (!empty($rowErrors)) {
                $this->errors = array_merge($this->errors, $rowErrors);
                continue;
            }

            // Create record
            try {
                $record = DataRecord::create([
                    'data_type_id' => $this->dataType->id,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);

                foreach ($values as $fieldId => $value) {
                    DataRecordValue::create([
                        'data_record_id' => $record->id,
                        'data_field_id' => $fieldId,
                        'value' => $value,
                    ]);
                }

                $this->imported++;
            } catch (\Exception $e) {
                $this->errors[] = "Baris " . ($i + 1) . ": Gagal menyimpan data - " . $e->getMessage();
            }
        }

        return [
            'success' => $this->imported > 0,
            'imported' => $this->imported,
            'errors' => $this->errors,
        ];
    }
}