@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Berikut ringkasan aktivitas produktivitas Anda hari ini.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
        
        <button id="pwa-install-button-top" onclick="installPWA()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all" style="display: none;" title="Install App">
            <i class="ph-bold ph-download"></i>
        </button>
        
        <a href="{{ route('tasks.create') }}" class="flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-glow trans-all transform hover:-translate-y-1">
            <i class="ph-bold ph-plus"></i>
            <span class="hidden sm:inline">Tugas Baru</span>
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 flex items-center gap-5 group hover:border-primary-200 dark:hover:border-primary-900 trans-all">
        <div class="w-16 h-16 rounded-2xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-500 group-hover:scale-110 trans-all">
            <i class="ph-duotone ph-list-checks text-3xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tugas</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalTasks }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 flex items-center gap-5 group hover:border-primary-200 dark:hover:border-primary-900 trans-all">
        <div class="w-16 h-16 rounded-2xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-500 group-hover:scale-110 trans-all">
            <i class="ph-duotone ph-clock-countdown text-3xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sedang Berjalan</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $inProgressTasks }}</h3>
        </div>
    </div>
    <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 flex items-center gap-5 group hover:border-primary-200 dark:hover:border-primary-900 trans-all">
        <div class="w-16 h-16 rounded-2xl bg-primary-50 dark:bg-primary-500/10 flex items-center justify-center text-primary-500 group-hover:scale-110 trans-all">
            <i class="ph-duotone ph-trophy text-3xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Selesai</p>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $completedTasks }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 space-y-8">
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Progres Analitik</h3>
            <div class="h-[250px] w-full"><canvas id="productivityChart"></canvas></div>
        </div>
        
        <!-- Task List -->
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Tugas Terbaru</h3>
            <div class="space-y-4">
                @forelse($recentTasks as $task)
                    <div class="flex items-center p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                        <div class="w-10 h-10 rounded-full {{ $task->priority === 'high' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center mr-4">
                            <i class="ph-bold {{ $task->priority === 'high' ? 'ph-warning' : 'ph-file-text' }}"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold dark:text-white">{{ $task->title }}</h4>
                            <p class="text-xs text-gray-500">Deadline: {{ $task->due_date ? $task->due_date->format('d M Y') : 'Belum ditentukan' }}</p>
                        </div>
                        <a href="{{ route('tasks.edit', $task) }}" class="text-primary-500 hover:text-primary-600">
                            <i class="ph-bold ph-pencil-simple"></i>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada tugas</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Mini Calendar & Activity -->
    <div class="space-y-8">
        <div class="bg-primary-500 text-white p-8 rounded-[2rem] shadow-glow relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <h3 class="text-lg font-bold relative z-10">{{ now()->timezone('Asia/Jakarta')->format('F Y') }}</h3>
            <div class="grid grid-cols-7 text-center text-xs opacity-70 mt-4 mb-2">
                <div>S</div><div>S</div><div>R</div><div>K</div><div>J</div><div>S</div><div>M</div>
            </div>
            <div class="grid grid-cols-7 text-center gap-2 text-sm relative z-10">
                @php
                    $startOfMonth = now()->timezone('Asia/Jakarta')->startOfMonth();
                    $endOfMonth = now()->timezone('Asia/Jakarta')->endOfMonth();
                    $startDay = $startOfMonth->dayOfWeek;
                    $daysInMonth = $endOfMonth->day;
                @endphp
                
                @for($i = 0; $i < $startDay; $i++)
                    <div class="opacity-30">{{ $startOfMonth->copy()->subDays($startDay - $i)->day }}</div>
                @endfor
                
                @for($day = 1; $day <= $daysInMonth; $day++)
                    <div class="{{ $day == now()->timezone('Asia/Jakarta')->day ? 'bg-white text-primary-600 rounded-lg shadow-md' : '' }}">
                        {{ $day }}
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Aktivitas</h3>
            <div class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                @forelse($activities as $activity)
                    <p>• {!! $activity->description !!}</p>
                @empty
                    <p class="text-center">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('productivityChart').getContext('2d');
    let myChart;

    function initChart() {
        const isDark = html.classList.contains('dark');
        const gridColor = isDark ? '#334155' : '#e2e8f0';
        const textColor = isDark ? '#94a3b8' : '#64748b';
        
        let gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(73, 0, 199, 0.4)');
        gradient.addColorStop(1, 'rgba(73, 0, 199, 0)');
        
        const config = {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Tugas Selesai',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: gradient,
                    borderColor: '#4900c7',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4900c7',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: gridColor, borderDash: [5, 5], drawBorder: false }, 
                        ticks: { color: textColor } 
                    },
                    x: { 
                        grid: { display: false }, 
                        ticks: { color: textColor } 
                    }
                }
            }
        };

        if (myChart) myChart.destroy();
        myChart = new Chart(ctx, config);
    }

    initChart();
</script>
@endpush