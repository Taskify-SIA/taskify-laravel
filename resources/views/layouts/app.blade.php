<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('icon.png') }}" type="image/png">
    {{-- PWA --}}
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#4900c7">
    {{-- Icon Apple --}}
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}" type="image/png">
    <title>{{ config('app.name', 'Taskify')  }} - @yield('title')</title>
    <meta name="description" content="Taskify - Kelola tugas Anda dengan mudah">
    <meta name="keywords" content="taskify, tugas, mudah, kelola, manajemen, waktu, efisiensi, productivity, timeline, prioritas, reminder, laporan, dashboard, project, team, collaboration, communication, documentation, reporting, analytics, dashboard, dashboard, dashboard">
    <meta name="author" content="Alif Bima Pradana">
   
    {{-- Meta og facebook --}}
    <meta property="og:title" content="Taskify - Kelola Tugas Anda Dengan Mudah">
    <meta property="og:description" content="Taskify - Kelola tugas Anda dengan mudah">
    <meta property="og:image" content="{{asset('/icon.png')}}">
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="191">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kms.jtifung.com">
    <meta property="og:site_name" content="Taskify">

    {{-- Meta og twitter --}}
    <meta name="twitter:title" content="Taskify - Kelola Tugas Anda Dengan Mudah">
    <meta name="twitter:description" content="Taskify - Kelola tugas Anda dengan mudah">
    <meta name="twitter:image" content="{{asset('/icon.png')}}">
    <meta name="twitter:url" content="https://kms.jtifung.com">
    <meta name="twitter:site" content="@taskify">
    <meta name="twitter:creator" content="@alifbimapradana">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:lang" content="id">

    {{-- Canonical --}}
    <link rel="canonical" href="https://kms.jtifung.com">    
    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#4900c7',
                            50: '#f2eaff',
                            100: '#e0cfff',
                            200: '#c5a3ff',
                            300: '#a36dff',
                            400: '#7d33ff',
                            500: '#4900c7',
                            600: '#4200b3',
                            700: '#380099',
                            800: '#2e0080',
                            900: '#260066',
                        },
                        dark: {
                            bg: '#0f172a',
                            card: '#1e293b',
                            text: '#f1f5f9',
                            muted: '#94a3b8'
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(73, 0, 199, 0.05)',
                        'glow': '0 0 15px rgba(73, 0, 199, 0.3)',
                    }
                }
            }
        }
    </script>

    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .trans-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        .custom-checkbox input:checked + div {
            background-color: #4900c7; border-color: #4900c7;
        }
        .custom-checkbox input:checked + div svg { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-dark-bg dark:text-dark-text transition-colors duration-300 font-sans antialiased overflow-hidden">

    <div class="flex h-screen w-full relative">

        <!-- OVERLAY MOBILE -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden backdrop-blur-sm trans-all opacity-0" onclick="toggleSidebar()"></div>

        <!-- SIDEBAR -->
        <aside id="sidebar" class="absolute lg:relative z-30 w-72 h-full bg-white dark:bg-dark-card flex flex-col justify-between border-r border-gray-100 dark:border-gray-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-xl lg:shadow-none">
            
            <div class="p-8 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-500 flex items-center justify-center text-white shadow-glow">
                    <i class="ph-bold ph-squares-four text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Taskify<span class="text-primary-500">.</span></h1>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-4">Menu Utama</p>
                
                <a href="{{ route('dashboard') }}" class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400' }} font-medium trans-all">
                    <i class="ph-duotone ph-circles-four text-xl"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('tasks.index') }}" class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('tasks.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400' }} font-medium trans-all group">
                    <i class="ph-duotone ph-check-circle text-xl group-hover:scale-110 trans-all"></i>
                    Tugas Saya
                    @if(Auth::check())
                        <span class="ml-auto bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ Auth::user()->tasks()->where('status', 'in_progress')->count() }}</span>
                    @endif
                </a>
                
                <a href="{{ route('calendar.index') }}" class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('calendar.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400' }} font-medium trans-all group">
                    <i class="ph-duotone ph-calendar-blank text-xl group-hover:scale-110 trans-all"></i>
                    Kalender
                </a>
                
                <a href="{{ route('analytics.index') }}" class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('analytics.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400' }} font-medium trans-all group">
                    <i class="ph-duotone ph-chart-pie-slice text-xl group-hover:scale-110 trans-all"></i>
                    Analitik
                </a>
                
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-8">Lainnya</p>
                
                <a href="{{ route('team.index') }}" class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('team.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400' }} font-medium trans-all group">
                    <i class="ph-duotone ph-users text-xl group-hover:scale-110 trans-all"></i>
                    Tim
                </a>
                
                <a href="{{ route('profile.edit') }}" class="nav-item flex items-center gap-3 px-4 py-3.5 rounded-2xl {{ request()->routeIs('profile.*') ? 'bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400' }} font-medium trans-all group">
                    <i class="ph-duotone ph-gear text-xl group-hover:scale-110 trans-all"></i>
                    Pengaturan
                </a>
                
                {{-- PWA Install Button --}}
                <button id="pwa-install-button" onclick="installPWA()" class="nav-item w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800 hover:text-primary-600 dark:hover:text-primary-400 font-medium trans-all group" style="display: none;">
                    <i class="ph-duotone ph-download text-xl group-hover:scale-110 trans-all"></i>
                    Install App
                </button>
            </nav>

            <div class="p-6 border-t border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-800 p-3 rounded-2xl border border-gray-100 dark:border-gray-700">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="User" class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-600 shadow-sm">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <button type="button" onclick="openLogoutModal()" class="text-gray-400 hover:text-red-500 trans-all">
                        <i class="ph-bold ph-sign-out text-lg"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 h-full overflow-y-auto overflow-x-hidden relative">
            
            <!-- Mobile Header -->
            <header class="lg:hidden flex items-center justify-between p-6 pb-2">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="py-2 px-3 rounded-xl bg-white dark:bg-dark-card shadow-sm border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300">
                        <i class="ph-bold ph-list text-xl"></i>
                    </button>
                    <h2 class="text-xl font-bold dark:text-white">@yield('page-title', 'Dashboard')</h2>
                </div>
                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary-500">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="User">
                </div>
            </header>

            <div class="p-6 lg:p-10 max-w-8xl mx-auto">
                
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl flex items-center gap-3">
                        <i class="ph-bold ph-check-circle text-2xl text-green-600 dark:text-green-400"></i>
                        <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl flex items-center gap-3">
                        <i class="ph-bold ph-warning text-2xl text-red-600 dark:text-red-400"></i>
                        <p class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</p>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Dark Mode
        const html = document.documentElement;
        const themeIcon = document.getElementById('themeIcon');
        
        function toggleDarkMode() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                if(themeIcon) themeIcon.classList.replace('ph-sun', 'ph-moon');
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                if(themeIcon) themeIcon.classList.replace('ph-moon', 'ph-sun');
            }
        }

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            if(themeIcon) themeIcon.classList.replace('ph-moon', 'ph-sun');
        }

        // Sidebar Mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        let isSidebarOpen = false;

        function toggleSidebar() {
            isSidebarOpen = !isSidebarOpen;
            if (isSidebarOpen) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
            }
        }
    </script>
    
    {{-- Toast Notifications --}}
    @include('components.toast-notification')
    
    {{-- Logout Modal --}}
    @include('components.modal-logout')
    
    @stack('scripts')
    
    {{-- PWA Service Worker Registration --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('Service Worker registered successfully:', registration.scope);
                    })
                    .catch(function(error) {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }
        
        // PWA Install Handler
        let deferredPrompt;
        let installButton = null;
        
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            console.log('PWA install prompt available');
            
            // Show install button if exists
            if (installButton) {
                installButton.style.display = 'flex';
            }
            const installButtonTop = document.getElementById('pwa-install-button-top');
            if (installButtonTop) {
                installButtonTop.style.display = 'block';
            }
        });
        
        // Check if already installed
        window.addEventListener('appinstalled', () => {
            console.log('PWA installed');
            deferredPrompt = null;
            if (installButton) {
                installButton.style.display = 'none';
            }
            const installButtonTop = document.getElementById('pwa-install-button-top');
            if (installButtonTop) {
                installButtonTop.style.display = 'none';
            }
        });
        
        // Function to install PWA
        window.installPWA = function() {
            if (!deferredPrompt) {
                alert('Aplikasi sudah terinstall atau tidak tersedia untuk diinstall.');
                return;
            }
            
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the install prompt');
                } else {
                    console.log('User dismissed the install prompt');
                }
                deferredPrompt = null;
                if (installButton) {
                    installButton.style.display = 'none';
                }
                const installButtonTop = document.getElementById('pwa-install-button-top');
                if (installButtonTop) {
                    installButtonTop.style.display = 'none';
                }
            });
        };
        
        // Initialize install button after DOM loaded
        document.addEventListener('DOMContentLoaded', function() {
            installButton = document.getElementById('pwa-install-button');
            const installButtonTop = document.getElementById('pwa-install-button-top');
            
            // Check if already installed
            if (window.matchMedia('(display-mode: standalone)').matches) {
                if (installButton) installButton.style.display = 'none';
                if (installButtonTop) installButtonTop.style.display = 'none';
            } else if (deferredPrompt) {
                // Show buttons if prompt available
                if (installButton) installButton.style.display = 'flex';
                if (installButtonTop) installButtonTop.style.display = 'block';
            }
        });
    </script>
</body>
</html>