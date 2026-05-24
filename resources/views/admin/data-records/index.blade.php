@extends('layouts.admin')
@section('title', 'Data ' . $dataType->name)
@section('content')
@php
    $hasAccess = auth()->user()->isSuperadmin() || auth()->user()->dataTypes()->where('data_types.id', $dataType->id)->exists();
@endphp
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">{{ $dataType->name }}</h2>
        <p class="text-gray-500">{{ $dataType->description }}</p>
    </div>
    <div class="space-x-2 flex flex-wrap gap-2">
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
        @if($hasAccess)
        <a href="{{ route('admin.data-types.records.create', $dataType) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>Tambah Data
        </a>
        <a href="{{ route('admin.data-types.records.template', $dataType) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            <i class="fas fa-download mr-2"></i>Download Template
        </a>
        <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
            <i class="fas fa-upload mr-2"></i>Import Excel
        </button>
        @endif
        <a href="?{{ http_build_query(array_merge(request()->except('export'), ['export' => 'excel'])) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-download mr-2"></i>Export Excel
        </a>
    </div>
</div>

<!-- Import Errors -->
@if(session('import_errors'))
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
    <h4 class="font-semibold mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Error Import ({{ count(session('import_errors')) }})</h4>
    <ul class="list-disc list-inside text-sm space-y-1 max-h-40 overflow-y-auto">
        @foreach(session('import_errors') as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Search & Filter -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full border rounded px-3 py-2">
        </div>
        @foreach($filterableFields as $field)
        <div>
            @if($field->type === 'dropdown')
            <select name="filter_{{ $field->name }}" class="w-full border rounded px-3 py-2">
                <option value="">Filter {{ $field->label }}</option>
                @foreach((is_array($field->options) ? $field->options : json_decode($field->options, true) ?? []) as $opt)
                    <option value="{{ $opt }}" {{ request('filter_'.$field->name) == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
            @else
            <input type="text" name="filter_{{ $field->name }}" value="{{ request('filter_'.$field->name) }}" placeholder="Filter {{ $field->label }}" class="w-full border rounded px-3 py-2">
            @endif
        </div>
        @endforeach
        <div class="flex space-x-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-search mr-1"></i>Cari
            </button>
            <a href="{{ route('admin.data-types.records.index', $dataType) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">No</th>
                @foreach($tableFields as $field)
                <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">
                    @if($field->is_sortable)
                        <a href="?{{ http_build_query(array_merge(request()->except('page'), ['sort' => $field->name, 'direction' => request('sort') == $field->name && request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-gray-700">
                            {{ $field->label }}
                            @if(request('sort') == $field->name)
                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1 text-xs"></i>
                            @endif
                        </a>
                    @else
                        {{ $field->label }}
                    @endif
                </th>
                @endforeach
                <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($records as $record)
            <tr class="hover:bg-gray-50">
                <td class="py-3 px-4 text-sm">{{ $loop->iteration + ($records->currentPage()-1) * $records->perPage() }}</td>
                @foreach($tableFields as $field)
                <td class="py-3 px-4 text-sm">
                    @php $val = $record->getValue($field->name); @endphp
                    @if($field->type === 'image' && $val)
                        <img src="{{ asset('storage/' . $val) }}" class="h-10 w-10 rounded object-cover">
                    @elseif($field->type === 'file' && $val)
                        <a href="{{ asset('storage/' . $val) }}" target="_blank" class="text-blue-600">
                            <i class="fas fa-download"></i> Download
                        </a>
                    @else
                        {{ Str::limit($val, 50) }}
                    @endif
                </td>
                @endforeach
                <td class="py-3 px-4 text-sm">
                    @if($hasAccess)
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.data-types.records.edit', [$dataType, $record]) }}" class="text-yellow-600 hover:text-yellow-800">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.data-types.records.destroy', [$dataType, $record]) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                    @else
                    <span class="text-gray-400 text-xs italic">Hanya lihat</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ count($tableFields) + 2 }}" class="py-12 text-center text-gray-400">
                    <i class="fas fa-database text-3xl mb-2 block"></i>
                    Belum ada data.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $records->links() }}
</div>

<!-- Import Modal -->
@if($hasAccess)
<div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 p-6">
        <h3 class="text-lg font-semibold mb-4">Import Data {{ $dataType->name }}</h3>
        <form action="{{ route('admin.data-types.records.import', $dataType) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih File Excel</label>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">Format: .xlsx, .xls, atau .csv (Maks 10MB)</p>
            </div>
            <div class="mb-4 p-3 bg-blue-50 rounded text-sm text-blue-700">
                <i class="fas fa-info-circle mr-1"></i>
                Pastikan header file sesuai dengan template. 
                <a href="{{ route('admin.data-types.records.template', $dataType) }}" class="underline font-semibold">Download template</a> terlebih dahulu.
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700">
                    <i class="fas fa-upload mr-2"></i>Import
                </button>
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection