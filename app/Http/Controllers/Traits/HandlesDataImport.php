<?php

namespace App\Http\Controllers\Traits;

use App\Exports\DataTypeTemplateExport;
use App\Imports\DataTypeImport;
use App\Models\DataType;
use Illuminate\Http\Request;

trait HandlesDataImport
{
    public function downloadTemplate(DataType $dataType)
    {
        $export = new DataTypeTemplateExport($dataType);
        return $export->download();
    }

    public function import(Request $request, DataType $dataType)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $importer = new DataTypeImport($dataType);
        $result = $importer->import($request->file('file'));

        $route = auth()->user()->isSuperadmin()
            ? 'superadmin.data-types.records.index'
            : 'admin.data-types.records.index';

        if ($result['imported'] > 0) {
            $message = "Berhasil mengimpor {$result['imported']} data.";
            if (!empty($result['errors'])) {
                $message .= " Namun terdapat " . count($result['errors']) . " baris yang gagal.";
                return redirect()->route($route, $dataType)
                    ->with('success', $message)
                    ->with('import_errors', $result['errors']);
            }
            return redirect()->route($route, $dataType)
                ->with('success', $message);
        }

        return redirect()->route($route, $dataType)
            ->with('error', 'Tidak ada data yang berhasil diimpor.')
            ->with('import_errors', $result['errors']);
    }
}