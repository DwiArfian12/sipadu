@extends('layouts.superadmin')
@section('title', 'Tambah Pengguna')
@section('content')
<h2 class="text-2xl font-bold mb-6">Tambah Pengguna Baru</h2>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('superadmin.users.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded px-3 py-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                <select name="role" required class="w-full border rounded px-3 py-2" onchange="toggleDataTypeAssignment(this)">
                    <option value="">Pilih Role</option>
                    <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="admin_data" {{ old('role') === 'admin_data' ? 'selected' : '' }}>Admin Data</option>
                </select>
                @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                <input type="password" name="password" required class="w-full border rounded px-3 py-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div id="dataTypeAssignment" class="mt-4 {{ old('role') === 'admin_data' ? '' : 'hidden' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Assign ke Jenis Data</label>
            <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border rounded p-2">
                @foreach($dataTypes as $dt)
                <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                    <input type="checkbox" name="assigned_data_types[]" value="{{ $dt->id }}"
                           {{ in_array($dt->id, old('assigned_data_types', [])) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-green-600">
                    <span class="text-sm">{{ $dt->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex space-x-3 mt-6">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
            <a href="{{ route('superadmin.users.index') }}" class="bg-gray-300 px-6 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function toggleDataTypeAssignment(select) {
    document.getElementById('dataTypeAssignment').classList.toggle('hidden', select.value !== 'admin_data');
}
</script>
@endpush
@endsection