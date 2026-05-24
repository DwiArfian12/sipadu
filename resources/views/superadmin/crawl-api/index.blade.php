@extends('layouts.superadmin')
@section('title', 'Crawling & API')
@section('content')
<h2 class="text-2xl font-bold mb-6">Crawling & API Data</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Crawling Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">
            <i class="fas fa-spider text-blue-600 mr-2"></i>Manual Crawling
        </h3>
        <p class="text-gray-600 mb-4 text-sm">Jalankan crawling data dari sumber eksternal secara manual.</p>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Target URL</label>
                <input type="text" class="w-full border rounded px-3 py-2" placeholder="https://www.uny.ac.id/berita">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Data Target</label>
                <select class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Jenis Data</option>
                    @foreach($dataTypes as $dt)
                        <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CSS / XPath Selector</label>
                <input type="text" class="w-full border rounded px-3 py-2" placeholder=".article-title">
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-play mr-2"></i>Jalankan Crawling
            </button>
        </div>

        <div class="mt-6 pt-4 border-t">
            <h4 class="font-medium mb-2 text-sm">Riwayat Crawling</h4>
            <p class="text-gray-400 text-sm">Fitur ini akan diimplementasikan selanjutnya.</p>
        </div>
    </div>

    <!-- API Integration Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">
            <i class="fas fa-plug text-green-600 mr-2"></i>API Integration
        </h3>
        <p class="text-gray-600 mb-4 text-sm">Ambil data dari API sistem UNY yang tersedia.</p>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">API Endpoint</label>
                <input type="url" class="w-full border rounded px-3 py-2" placeholder="https://api.uny.ac.id/v1/mahasiswa">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Method</label>
                <select class="w-full border rounded px-3 py-2">
                    <option value="GET">GET</option>
                    <option value="POST">POST</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">API Key (jika diperlukan)</label>
                <input type="text" class="w-full border rounded px-3 py-2" placeholder="sk-xxxxxxxx">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Data Target</label>
                <select class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Jenis Data</option>
                    @foreach($dataTypes as $dt)
                        <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Field Mapping (JSON Path mapping)</label>
                <textarea rows="3" class="w-full border rounded px-3 py-2 font-mono text-sm" placeholder='{"nama": "data.nama", "nim": "data.nim"}'></textarea>
            </div>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-sync-alt mr-2"></i>Fetch Data
            </button>
        </div>

        <div class="mt-6 pt-4 border-t">
            <h4 class="font-medium mb-2 text-sm">Riwayat API Call</h4>
            <p class="text-gray-400 text-sm">Fitur ini akan diimplementasikan selanjutnya.</p>
        </div>
    </div>
</div>

<!-- Scheduled Tasks Section -->
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h3 class="text-lg font-semibold mb-4">
        <i class="fas fa-clock text-purple-600 mr-2"></i>Penjadwalan Otomatis
    </h3>
    <p class="text-gray-400 text-sm">Fitur penjadwalan crawling dan API call otomatis akan diimplementasikan selanjutnya.</p>
</div>
@endsection