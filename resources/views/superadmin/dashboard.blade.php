@extends('layouts.superadmin')
@section('title', 'Dashboard')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold">Dashboard Superadmin</h2>
    <p class="text-gray-500">Selamat datang, {{ auth()->user()->name }}! Kelola seluruh data dan pengguna SIPADU UNY.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-database text-green-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Jenis Data</p>
                <p class="text-2xl font-bold">{{ $totalDataTypes }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Records</p>
                <p class="text-2xl font-bold">{{ $totalRecords }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-users text-purple-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Pengguna</p>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-lg font-semibold mb-4">Jenis Data Terbaru</h3>
    <table class="min-w-full">
        <thead>
            <tr class="border-b">
                <th class="text-left py-2">Nama</th>
                <th class="text-left py-2">Slug</th>
                <th class="text-left py-2">Field</th>
                <th class="text-left py-2">Dibuat Oleh</th>
                <th class="text-left py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentDataTypes as $dt)
            <tr class="border-b">
                <td class="py-2">
                    <a href="{{ route('superadmin.data-types.fields.index', $dt) }}" class="text-green-700 hover:underline">
                        {{ $dt->name }}
                    </a>
                </td>
                <td class="py-2 text-gray-600">{{ $dt->slug }}</td>
                <td class="py-2 text-gray-600">{{ $dt->fields->count() }} field</td>
                <td class="py-2 text-gray-600">{{ $dt->creator?->name }}</td>
                <td class="py-2 text-gray-600">{{ $dt->created_at?->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection