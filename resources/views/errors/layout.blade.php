<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <!-- Fonts: Plus Jakarta Sans -->
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

        /* Animation for page switching */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 dark:bg-dark-bg dark:text-dark-text transition-colors duration-300 font-sans antialiased">
    <div class="flex h-screen w-full relative">
        <!-- Main Content Area -->
        <main class="flex-1 h-full overflow-y-auto overflow-x-hidden relative flex items-center justify-center">
            <div class="p-6 lg:p-10 max-w-8xl mx-auto w-full">
                <div class="flex flex-col items-center justify-center min-h-[70vh]">
                    <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 text-center max-w-2xl w-full animate-fade-in">
                        <div class="w-24 h-24 rounded-2xl bg-primary-50 dark:bg-primary-500/10 flex items-center justify-center text-primary-500 mx-auto mb-6">
                            <i class="ph-duotone ph-warning text-5xl"></i>
                        </div>
                        
                        <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-2">@yield('code')</h1>
                        
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">@yield('title')</h2>
                        
                        <p class="text-gray-500 dark:text-dark-muted mb-8 text-lg">
                            @yield('message')
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ url('/') }}" class="flex items-center justify-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-glow trans-all transform hover:-translate-y-1">
                                <i class="ph-bold ph-house"></i>
                                Kembali ke Beranda
                            </a>
                            
                            <button onclick="history.back()" class="flex items-center justify-center gap-2 bg-white dark:bg-dark-card hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-2xl font-semibold shadow-soft border border-gray-200 dark:border-gray-700 trans-all">
                                <i class="ph-bold ph-arrow-left"></i>
                                Halaman Sebelumnya
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-8 text-center text-gray-500 dark:text-dark-muted text-sm">
                        <p>© {{ date('Y') }} Taskify. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Dark Mode Toggle
        const html = document.documentElement;
        
        // Check for saved theme preference or respect OS preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        }
    </script>
</body>
</html>