<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Admin\DataRecordController;
use App\Models\DataType;

class SuperadminDataRecordController extends DataRecordController
{
    /**
     * Override index to use superadmin view
     */
    public function index(\Illuminate\Http\Request $request, DataType $dataType)
    {
        $this->authorizeAccess($dataType);

        $allFields = $dataType->fields()->orderBy('order')->get();
        $tableFields = $allFields->where('show_in_table', true);

        $query = \App\Models\DataRecord::where('data_type_id', $dataType->id)->with(['values.field', 'creator']);

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

        // Filter
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
                    \App\Models\DataRecordValue::select('value')
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

        return view('superadmin.data-records.index', compact(
            'dataType',
            'tableFields',
            'records',
            'filterableFields'
        ));
    }

    /**
     * Override create to use superadmin view
     */
    public function create(\App\Models\DataType $dataType)
    {
        $this->authorizeAccess($dataType);
        $fields = $dataType->fields()->orderBy('order')->get();
        return view('superadmin.data-records.create', compact('dataType', 'fields'));
    }

    /**
     * Override edit to use superadmin view
     */
    public function edit(\App\Models\DataType $dataType, \App\Models\DataRecord $record)
    {
        $this->authorizeAccess($dataType);
        $fields = $dataType->fields()->orderBy('order')->get();
        return view('superadmin.data-records.edit', compact('dataType', 'record', 'fields'));
    }
}