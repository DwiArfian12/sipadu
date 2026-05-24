@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold">Dashboard Admin Data</h2>
    <p class="text-gray-500">Selamat datang, {{ auth()->user()->name }}! Kelola data yang di-assign kepada Anda.</p>
</div>

@if($assignedDataTypes->isEmpty())
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
        <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl mb-3"></i>
        <p class="text-yellow-700 font-medium">Belum ada jenis data yang di-assign ke akun Anda.</p>
        <p class="text-yellow-600 text-sm mt-1">Silakan hubungi Superadmin untuk mendapatkan akses ke jenis data.</p>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($assignedDataTypes as $dt)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-database text-green-600 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">{{ $dt->name }}</p>
                        <p class="text-2xl font-bold">{{ $dt->records_count ?? 0 }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.data-types.records.index', $dt) }}" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-arrow-right text-lg"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Akses Cepat</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($assignedDataTypes as $dt)
            <a href="{{ route('admin.data-types.records.index', $dt) }}" 
               class="p-4 border rounded-lg hover:bg-green-50 hover:border-green-300 transition text-center">
                <i class="fas fa-table text-2xl text-green-600 mb-2"></i>
                <p class="text-sm font-medium">{{ $dt->name }}</p>
            </a>
            @endforeach
            <a href="{{ route('admin.crawl-api.index') }}" 
               class="p-4 border rounded-lg hover:bg-purple-50 hover:border-purple-300 transition text-center">
                <i class="fas fa-spider text-2xl text-purple-600 mb-2"></i>
                <p class="text-sm font-medium">Crawling & API</p>
            </a>
        </div>
    </div>
@endif
@endsection