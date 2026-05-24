<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\DataType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataTypeController extends Controller
{
    public function index()
    {
        $dataTypes = DataType::with(['creator', 'users', 'fields'])->latest()->paginate(10);
        return view('superadmin.data-types.index', compact('dataTypes'));
    }

    public function create()
    {
        $admins = User::where('role', 'admin_data')->get();
        return view('superadmin.data-types.create', compact('admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:data_types,slug',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['created_by'] = auth()->id();

        $dataType = DataType::create($validated);

        if ($request->has('assigned_admins')) {
            $dataType->users()->sync($request->assigned_admins);
        }

        return redirect()->route('superadmin.data-types.index')
            ->with('success', 'Jenis Data berhasil dibuat.');
    }

    public function edit(DataType $dataType)
    {
        $admins = User::where('role', 'admin_data')->get();
        $assignedAdmins = $dataType->users->pluck('id')->toArray();
        return view('superadmin.data-types.edit', compact('dataType', 'admins', 'assignedAdmins'));
    }

    public function update(Request $request, DataType $dataType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:data_types,slug,' . $dataType->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $dataType->update($validated);

        if ($request->has('assigned_admins')) {
            $dataType->users()->sync($request->assigned_admins);
        } else {
            $dataType->users()->sync([]);
        }

        return redirect()->route('superadmin.data-types.index')
            ->with('success', 'Jenis Data berhasil diperbarui.');
    }

    public function destroy(DataType $dataType)
    {
        $dataType->delete();
        return redirect()->route('superadmin.data-types.index')
            ->with('success', 'Jenis Data berhasil dihapus.');
    }
}