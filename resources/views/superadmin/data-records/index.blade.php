@extends('layouts.superadmin')
@section('title', 'Data ' . $dataType->name)
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold">Data {{ $dataType->name }}</h2>
        <p class="text-gray-500">{{ $dataType->description }}</p>
    </div>
    <div class="space-x-2">
        <a href="{{ route('superadmin.data-types.records.create', $dataType) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>Tambah Data
        </a>
        <a href="?{{ http_build_query(array_merge(request()->except('export'), ['export' => 'excel'])) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-file-excel mr-2"></i>Export Excel
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="w-full border rounded px-3 py-2" placeholder="Cari...">
        </div>
        @foreach($filterableFields as $field)
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $field->label }}</label>
            @if($field->type === 'dropdown')
            <select name="filter_{{ $field->name }}" class="border rounded px-3 py-2">
                <option value="">Semua</option>
                @foreach((is_array($field->options) ? $field->options : json_decode($field->options, true) ?? []) as $opt)
                    <option value="{{ $opt }}" {{ request('filter_'.$field->name) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
            @else
            <input type="text" name="filter_{{ $field->name }}" value="{{ request('filter_'.$field->name) }}" class="border rounded px-3 py-2">
            @endif
        </div>
        @endforeach
        <div>
            <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                <i class="fas fa-search mr-1"></i>Filter
            </button>
            <a href="{{ route('superadmin.data-types.records.index', $dataType) }}" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400 ml-2 inline-block">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-4 w-12">#</th>
                    @foreach($tableFields as $field)
                    <th class="text-left py-3 px-4 whitespace-nowrap">
                        <a href="{{ route('superadmin.data-types.records.index', array_merge(['dataType' => $dataType], request()->all(), ['sort' => $field->name, 'direction' => request('sort') === $field->name && request('direction') !== 'desc' ? 'desc' : 'asc'])) }}" class="hover:text-green-600">
                            {{ $field->label }}
                            @if(request('sort') === $field->name)
                                <i class="fas fa-sort-{{ request('direction') === 'desc' ? 'down' : 'up' }} text-green-600"></i>
                            @else
                                <i class="fas fa-sort text-gray-400"></i>
                            @endif
                        </a>
                    </th>
                    @endforeach
                    <th class="text-left py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-3 px-4 text-gray-500">{{ $loop->iteration + ($records->currentPage() - 1) * $records->perPage() }}</td>
                    @foreach($tableFields as $field)
                    <td class="py-3 px-4">
                        @php $value = $record->getValue($field->name); @endphp
                        @if($field->type === 'image' && $value)
                            <img src="{{ asset('storage/' . $value) }}" class="h-10 w-16 object-cover rounded">
                        @elseif($field->type === 'file' && $value)
                            <a href="{{ asset('storage/' . $value) }}" target="_blank" class="text-blue-600 hover:underline">
                                <i class="fas fa-download mr-1"></i>File
                            </a>
                        @else
                            <span class="text-sm">{{ Str::limit($value, 50) }}</span>
                        @endif
                    </td>
                    @endforeach
                    <td class="py-3 px-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('superadmin.data-types.records.edit', [$dataType, $record]) }}" class="text-yellow-600 hover:text-yellow-800">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('superadmin.data-types.records.destroy', [$dataType, $record]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($records->isEmpty())
                <tr>
                    <td colspan="{{ count($tableFields) + 2 }}" class="py-8 text-center text-gray-400">
                        Belum ada data. <a href="{{ route('superadmin.data-types.records.create', $dataType) }}" class="text-green-600 hover:underline">Tambah data pertama</a>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">
        {{ $records->appends(request()->query())->links() }}
    </div>
</div>
@endsection