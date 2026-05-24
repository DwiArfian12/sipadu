@extends('layouts.superadmin')
@section('title', 'Jenis Data')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Jenis Data</h2>
    <a href="{{ route('superadmin.data-types.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
        <i class="fas fa-plus mr-2"></i>Tambah Jenis Data
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4">Nama</th>
                <th class="text-left py-3 px-4">Slug</th>
                <th class="text-left py-3 px-4">Field</th>
                <th class="text-left py-3 px-4">Assigned Admins</th>
                <th class="text-left py-3 px-4">Dibuat Oleh</th>
                <th class="text-left py-3 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataTypes as $dt)
            <tr class="border-t">
                <td class="py-3 px-4 font-medium">{{ $dt->name }}</td>
                <td class="py-3 px-4 text-gray-600">{{ $dt->slug }}</td>
                <td class="py-3 px-4">
                    <a href="{{ route('superadmin.data-types.fields.index', $dt) }}" class="text-green-600 hover:underline">
                        {{ $dt->fields->count() }} field
                    </a>
                </td>
                <td class="py-3 px-4 text-gray-600">
                    @if($dt->users->isNotEmpty())
                        {{ $dt->users->pluck('name')->join(', ') }}
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="py-3 px-4 text-gray-600">{{ $dt->creator?->name }}</td>
                <td class="py-3 px-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('superadmin.data-types.fields.index', $dt) }}" class="text-blue-600 hover:text-blue-800" title="Kelola Field">
                            <i class="fas fa-list"></i>
                        </a>
                        <a href="{{ route('superadmin.data-types.records.index', $dt) }}" class="text-purple-600 hover:text-purple-800" title="Data Records">
                            <i class="fas fa-file-alt"></i>
                        </a>
                        <a href="{{ route('superadmin.data-types.edit', $dt) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('superadmin.data-types.destroy', $dt) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jenis data ini? Semua field dan record akan terhapus.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">
        {{ $dataTypes->links() }}
    </div>
</div>
@endsection