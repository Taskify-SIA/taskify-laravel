<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('icon.png') }}" type="image/png">
    {{-- PWA --}}
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="theme-color" content="#4900c7">
    {{-- Icon Apple --}}
    <link rel="apple-touch-icon" href="{{ asset('icon.png') }}" type="image/png">
    <title>{{ config('app.name', 'Taskify') }}</title>
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
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

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
        body {
            background: #f6f6f6;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary-500 flex items-center justify-center shadow-glow">
                        <i class="ph-bold ph-squares-four text-2xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-primary">Taskify<span class="text-primary-500">.</span></h1>
                </div>
                <p class="text-primary-400">Kelola tugas Anda dengan mudah</p>
            </div>

            <!-- Content Card -->
            <div class="bg-white rounded-[2rem] shadow-2xl p-8 backdrop-blur-lg">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="text-center text-primary-600 text-sm mt-8">
                © 2025 Taskify. All rights reserved.
            </p>
        </div>
    </div>
    
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
        
        // Listen for beforeinstallprompt event
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            console.log('PWA install prompt available');
        });
    </script>
</body>
</html>