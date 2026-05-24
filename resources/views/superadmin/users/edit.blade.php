@extends('layouts.superadmin')
@section('title', 'Edit Pengguna')
@section('content')
<h2 class="text-2xl font-bold mb-6">Edit Pengguna: {{ $user->name }}</h2>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('superadmin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded px-3 py-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border rounded px-3 py-2">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
                <select name="role" required class="w-full border rounded px-3 py-2" onchange="toggleDataTypeAssignment(this)">
                    <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="admin_data" {{ old('role', $user->role) === 'admin_data' ? 'selected' : '' }}>Admin Data</option>
                </select>
                @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password (kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div id="dataTypeAssignment" class="mt-4 {{ old('role', $user->role) === 'admin_data' ? '' : 'hidden' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Assign ke Jenis Data</label>
            <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto border rounded p-2">
                @foreach($dataTypes as $dt)
                <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                    <input type="checkbox" name="assigned_data_types[]" value="{{ $dt->id }}"
                           {{ in_array($dt->id, old('assigned_data_types', $assignedDataTypes)) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-green-600">
                    <span class="text-sm">{{ $dt->name }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex space-x-3 mt-6">
            <button type="submit" class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700">
                <i class="fas fa-save mr-2"></i>Update
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