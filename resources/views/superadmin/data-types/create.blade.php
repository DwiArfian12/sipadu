@extends('layouts.superadmin')
@section('title', 'Tambah Jenis Data')
@section('content')
<h2 class="text-2xl font-bold mb-6">Tambah Jenis Data Baru</h2>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('superadmin.data-types.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Data *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   placeholder="Contoh: Berita UNY, Mahasiswa, Dosen">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Slug (opsional, auto-generate dari nama)</label>
            <input type="text" name="slug" value="{{ old('slug') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   placeholder="berita-uny">
            @error('slug') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                      placeholder="Deskripsi singkat tentang jenis data ini">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Assign ke Admin Data</label>
            <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-2">
                @foreach($admins as $admin)
                <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                    <input type="checkbox" name="assigned_admins[]" value="{{ $admin->id }}"
                           {{ in_array($admin->id, old('assigned_admins', [])) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="text-sm">{{ $admin->name }} ({{ $admin->email }})</span>
                </label>
                @endforeach
                @if($admins->isEmpty())
                <p class="text-sm text-gray-400 col-span-2">Belum ada admin data.</p>
                @endif
            </div>
        </div>
        <div class="flex space-x-3">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="{{ route('superadmin.data-types.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection