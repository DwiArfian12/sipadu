<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataField;
use App\Models\DataRecord;
use App\Models\DataRecordValue;
use App\Models\DataType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataRecordController extends Controller
{
    protected function getAccessibleDataTypes()
    {
        if (auth()->user()->isSuperadmin()) {
            return DataType::with('fields')->get();
        }
        return auth()->user()->dataTypes()->with('fields')->get();
    }

    public function index(Request $request, DataType $dataType)
    {
        $this->authorizeAccess($dataType);

        $allFields = $dataType->fields()->orderBy('order')->get();
        $tableFields = $allFields->where('show_in_table', true);

        $query = DataRecord::where('data_type_id', $dataType->id)->with(['values.field', 'creator']);

        // Search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $searchableFieldIds = $allFields->where('is_searchable', true)->pluck('id');
            $query->where(function ($q) use ($searchableFieldIds, $searchTerm) {
                $q->whereHas('values', function ($vq) use ($searchableFieldIds, $searchTerm) {
                    $vq->whereIn('data_field_id', $searchableFieldIds)
                        ->where('value', 'like', "%{$searchTerm}%");
                });
            });
        }

        // Filter - supports filter_{field_name} params from view
        $filterableFields = $allFields->where('is_filterable', true);
        foreach ($filterableFields as $field) {
            $paramName = 'filter_' . $field->name;
            if ($request->filled($paramName)) {
                $query->whereHas('values', function ($q) use ($field, $request, $paramName) {
                    $q->where('data_field_id', $field->id)
                        ->where('value', 'like', '%' . $request->$paramName . '%');
                });
            }
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if ($sortField === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        } else {
            $field = $allFields->firstWhere('name', $sortField);
            if ($field) {
                $query->orderBy(
                    DataRecordValue::select('value')
                        ->whereColumn('data_record_id', 'data_records.id')
                        ->where('data_field_id', $field->id)
                        ->limit(1),
                    $sortDirection
                );
            } else {
                $query->orderBy('created_at', 'desc');
            }
        }

        // Pagination
        $perPage = $request->get('per_page', 10);
        $records = $query->paginate($perPage)->appends($request->except('page'));

        // Export
        if ($request->get('export') === 'excel') {
            return $this->exportExcel($records, $tableFields, $dataType);
        }

        return view('admin.data-records.index', compact(
            'dataType',
            'tableFields',
            'records',
            'filterableFields'
        ));
    }

    public function create(DataType $dataType)
    {
        $this->authorizeAccess($dataType);
        $fields = $dataType->fields()->orderBy('order')->get();
        return view('admin.data-records.create', compact('dataType', 'fields'));
    }

    public function store(Request $request, DataType $dataType)
    {
        $this->authorizeAccess($dataType);
        $fields = $dataType->fields;

        // Build validation rules dynamically using fields[name] format
        $rules = [];
        foreach ($fields as $field) {
            $key = 'fields.' . $field->name;
            $rule = [];
            if ($field->required) {
                $rule[] = 'required';
            } else {
                $rule[] = 'nullable';
            }
            if ($field->type === 'image' || $field->type === 'file') {
                $rule[] = 'file';
                $rule[] = 'max:10240';
            }
            if ($field->type === 'number') {
                $rule[] = 'numeric';
            }
            if ($field->type === 'email') {
                $rule[] = 'email';
            }
            if ($field->type === 'url') {
                $rule[] = 'url';
            }
            $rules[$key] = $rule;
        }

        $validated = $request->validate($rules);

        $record = DataRecord::create([
            'data_type_id' => $dataType->id,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        foreach ($fields as $field) {
            $value = $request->input('fields.' . $field->name);

            if (in_array($field->type, ['image', 'file']) && $request->hasFile('fields.' . $field->name)) {
                $file = $request->file('fields.' . $field->name);
                $value = $file->store('uploads/' . $dataType->slug, 'public');
            }

            DataRecordValue::create([
                'data_record_id' => $record->id,
                'data_field_id' => $field->id,
                'value' => $value,
            ]);
        }

        $route = auth()->user()->isSuperadmin()
            ? 'superadmin.data-types.records.index'
            : 'admin.data-types.records.index';

        return redirect()->route($route, $dataType)
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(DataType $dataType, DataRecord $record)
    {
        $this->authorizeAccess($dataType);
        $fields = $dataType->fields()->orderBy('order')->get();
        return view('admin.data-records.edit', compact('dataType', 'record', 'fields'));
    }

    public function update(Request $request, DataType $dataType, DataRecord $record)
    {
        $this->authorizeAccess($dataType);
        $fields = $dataType->fields;

        $rules = [];
        foreach ($fields as $field) {
            $key = 'fields.' . $field->name;
            $rule = [];
            if ($field->required) {
                $rule[] = 'required';
            } else {
                $rule[] = 'nullable';
            }
            if ($field->type === 'image' || $field->type === 'file') {
                $rule[] = 'file';
                $rule[] = 'max:10240';
            }
            if ($field->type === 'number') {
                $rule[] = 'numeric';
            }
            if ($field->type === 'email') {
                $rule[] = 'email';
            }
            if ($field->type === 'url') {
                $rule[] = 'url';
            }
            $rules[$key] = $rule;
        }

        $validated = $request->validate($rules);

        $record->update(['updated_by' => auth()->id()]);

        foreach ($fields as $field) {
            $existingValue = $record->values()->where('data_field_id', $field->id)->first();

            if (in_array($field->type, ['image', 'file']) && $request->hasFile('fields.' . $field->name)) {
                // Delete old file
                if ($existingValue && $existingValue->value && Storage::disk('public')->exists($existingValue->value)) {
                    Storage::disk('public')->delete($existingValue->value);
                }
                $value = $request->file('fields.' . $field->name)->store('uploads/' . $dataType->slug, 'public');
            } else {
                $value = $request->input('fields.' . $field->name);
            }

            if ($existingValue) {
                $existingValue->update(['value' => $value]);
            } else {
                DataRecordValue::create([
                    'data_record_id' => $record->id,
                    'data_field_id' => $field->id,
                    'value' => $value,
                ]);
            }
        }

        $route = auth()->user()->isSuperadmin()
            ? 'superadmin.data-types.records.index'
            : 'admin.data-types.records.index';

        return redirect()->route($route, $dataType)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(DataType $dataType, DataRecord $record)
    {
        $this->authorizeAccess($dataType);
        $record->delete();

        $route = auth()->user()->isSuperadmin()
            ? 'superadmin.data-types.records.index'
            : 'admin.data-types.records.index';

        return redirect()->route($route, $dataType)
            ->with('success', 'Data berhasil dihapus.');
    }

    protected function authorizeAccess(DataType $dataType)
    {
        if (auth()->user()->isSuperadmin()) {
            return;
        }

        $hasAccess = auth()->user()->dataTypes()->where('data_types.id', $dataType->id)->exists();
        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke jenis data ini.');
        }
    }

    protected function exportExcel($records, $fields, $dataType)
    {
        $filename = $dataType->slug . '_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Transfer-Encoding' => 'binary',
        ];

        $callback = function () use ($records, $fields) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fwrite($file, "\xEF\xBB\xBF");

            // Headers
            $headerRow = $fields->pluck('label')->toArray();
            array_unshift($headerRow, 'No');
            array_push($headerRow, 'Dibuat Oleh', 'Tanggal Dibuat');
            fputcsv($file, $headerRow);

            // Data
            $no = ($records->currentPage() - 1) * $records->perPage() + 1;
            foreach ($records as $record) {
                $row = [$no++];
                foreach ($fields as $field) {
                    $row[] = $record->getValue($field->name);
                }
                $row[] = $record->creator?->name ?? 'N/A';
                $row[] = $record->created_at?->format('d/m/Y H:i') ?? '';
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}