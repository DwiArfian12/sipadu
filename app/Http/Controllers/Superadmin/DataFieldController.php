<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DataField;
use App\Models\DataType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataFieldController extends Controller
{
    public function index(DataType $dataType)
    {
        $fields = $dataType->fields()->orderBy('order')->get();
        return view('superadmin.data-fields.index', compact('dataType', 'fields'));
    }

    public function create(DataType $dataType)
    {
        return view('superadmin.data-fields.create', compact('dataType'));
    }

    public function store(Request $request, DataType $dataType)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:text,number,textarea,date,image,file,dropdown,email,url',
            'options' => 'nullable|string',
            'required' => 'boolean',
            'is_searchable' => 'boolean',
            'is_filterable' => 'boolean',
            'is_sortable' => 'boolean',
            'show_in_table' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['name'] = $validated['name'] ?: Str::slug($validated['label'], '_');
        $validated['data_type_id'] = $dataType->id;

        // Parse dropdown options
        if ($request->type === 'dropdown' && $request->filled('options')) {
            $validated['options'] = array_map('trim', explode("\n", $request->options));
        } else {
            $validated['options'] = null;
        }

        DataField::create($validated);

        return redirect()->route('superadmin.data-types.fields.index', $dataType)
            ->with('success', 'Field berhasil ditambahkan.');
    }

    public function edit(DataType $dataType, DataField $field)
    {
        return view('superadmin.data-fields.edit', compact('dataType', 'field'));
    }

    public function update(Request $request, DataType $dataType, DataField $field)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:text,number,textarea,date,image,file,dropdown,email,url',
            'options' => 'nullable|string',
            'required' => 'boolean',
            'is_searchable' => 'boolean',
            'is_filterable' => 'boolean',
            'is_sortable' => 'boolean',
            'show_in_table' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $validated['name'] = $validated['name'] ?: Str::slug($validated['label'], '_');

        if ($request->type === 'dropdown' && $request->filled('options')) {
            $validated['options'] = array_map('trim', explode("\n", $request->options));
        } else {
            $validated['options'] = null;
        }

        $field->update($validated);

        return redirect()->route('superadmin.data-types.fields.index', $dataType)
            ->with('success', 'Field berhasil diperbarui.');
    }

    public function destroy(DataType $dataType, DataField $field)
    {
        $field->delete();
        return redirect()->route('superadmin.data-types.fields.index', $dataType)
            ->with('success', 'Field berhasil dihapus.');
    }
}