<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AFDAPER - @yield('title', 'Dashboard')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-green-800 text-white flex-shrink-0 transition-all duration-300 relative">
            <div class="p-4 border-b border-green-700 flex items-center justify-between">
                <div class="flex items-center space-x-2 sidebar-header-text">
                    <i class="fas fa-database text-green-300 text-xl"></i>
                    <div>
                        <h1 class="text-xl font-bold">AFDAPER</h1>
                        <p class="text-xs text-green-300">Aplikasi Feeder Data Pemeringkatan UNY</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="text-green-300 hover:text-white">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <nav class="p-2 space-y-1">
                <a href="{{ route('superadmin.dashboard') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('superadmin.dashboard') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-tachometer-alt w-5 text-center"></i>
                    <span class="ml-3 nav-text">Dashboard</span>
                </a>
                <a href="{{ route('superadmin.data-types.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('superadmin.data-types.*') && !request()->routeIs('superadmin.data-types.records.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-database w-5 text-center"></i>
                    <span class="ml-3 nav-text">Jenis Data</span>
                </a>
                <a href="{{ route('superadmin.users.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('superadmin.users.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-users w-5 text-center"></i>
                    <span class="ml-3 nav-text">Manajemen Pengguna</span>
                </a>
                <a href="{{ route('superadmin.crawl-api.index') }}" 
                   class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->routeIs('superadmin.crawl-api.*') ? 'bg-green-700' : 'hover:bg-green-700' }}">
                    <i class="fas fa-spider w-5 text-center"></i>
                    <span class="ml-3 nav-text">Crawling & API</span>
                </a>

                <!-- Divider & Daftar Jenis Data -->
                <div class="border-t border-green-700 my-2 nav-text"></div>
                <div class="px-3 py-1 text-xs text-green-400 uppercase tracking-wider nav-text">Daftar Jenis Data</div>
                @php
                    $allDataTypes = \App\Models\DataType::orderBy('name')->get();
                @endphp
                @foreach($allDataTypes as $dt)
                    <a href="{{ route('superadmin.data-types.records.index', $dt) }}" 
                       class="flex items-center px-3 py-2 rounded-lg text-sm {{ request()->url() === route('superadmin.data-types.records.index', $dt) ? 'bg-green-700' : 'hover:bg-green-700' }}">
                        <i class="fas fa-table w-5 text-center"></i>
                        <span class="ml-3 nav-text">{{ $dt->name }}</span>
                    </a>
                @endforeach
            </nav>
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-green-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center px-3 py-2 text-sm text-green-300 hover:text-white w-full">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span class="ml-3 nav-text">Logout ({{ auth()->user()->name }})</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const isCollapsed = sidebar.classList.contains('w-16');
            
            if (isCollapsed) {
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
            } else {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
            }
            
            // Toggle header text
            document.querySelectorAll('.sidebar-header-text').forEach(el => {
                el.classList.toggle('hidden');
            });
            
            // Toggle nav text
            document.querySelectorAll('.nav-text').forEach(el => {
                el.classList.toggle('hidden');
            });
            
            // Center nav items when collapsed
            document.querySelectorAll('#sidebar nav a, #sidebar .absolute form button').forEach(el => {
                el.classList.toggle('justify-center');
                el.classList.toggle('px-3');
                el.classList.toggle('px-0');
            });
            
            // Adjust bottom section padding
            const bottomDiv = sidebar.querySelector('.absolute.bottom-0');
            if (bottomDiv) {
                bottomDiv.classList.toggle('p-4');
                bottomDiv.classList.toggle('p-2');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>