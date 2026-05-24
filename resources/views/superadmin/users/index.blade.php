@extends('layouts.superadmin')
@section('title', 'Manajemen Pengguna')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Manajemen Pengguna</h2>
    <a href="{{ route('superadmin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
        <i class="fas fa-plus mr-2"></i>Tambah Pengguna
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4">Nama</th>
                <th class="text-left py-3 px-4">Email</th>
                <th class="text-left py-3 px-4">NIP</th>
                <th class="text-left py-3 px-4">Role</th>
                <th class="text-left py-3 px-4">Assigned Data</th>
                <th class="text-left py-3 px-4">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-t">
                <td class="py-3 px-4">
                    <div class="font-medium">{{ $user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $user->phone }}</div>
                </td>
                <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                <td class="py-3 px-4 text-gray-600">{{ $user->nip ?? '-' }}</td>
                <td class="py-3 px-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $user->role === 'superadmin' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ $user->role === 'superadmin' ? 'Superadmin' : 'Admin Data' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-gray-600">
                    @if($user->role === 'admin_data')
                        {{ $user->dataTypes->pluck('name')->join(', ') ?: '-' }}
                    @else
                        <span class="text-gray-400">Semua</span>
                    @endif
                </td>
                <td class="py-3 px-4">
                    <div class="flex space-x-2">
                        <a href="{{ route('superadmin.users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">
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
        {{ $users->links() }}
    </div>
</div>
@endsection