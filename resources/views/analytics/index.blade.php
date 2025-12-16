@extends('layouts.app')

@section('title', 'Analitik')
@section('page-title', 'Analitik')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Analitik</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Statistik performa dan efisiensi kerja.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
        
        <form action="{{ route('analytics.index') }}" method="GET" class="flex items-center gap-2">
            <input type="hidden" name="range" id="range-input" value="{{ $range }}">
            <div class="px-1 py-1 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 flex">
                <button type="submit" onclick="document.getElementById('range-input').value='7d';" class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold
                    {{ $range === '7d' ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    7 Hari
                </button>
                <button type="submit" onclick="document.getElementById('range-input').value='30d';" class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold
                    {{ $range === '30d' ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    30 Hari
                </button>
                <button type="submit" onclick="document.getElementById('range-input').value='3m';" class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold
                    {{ $range === '3m' ? 'bg-primary-500 text-white' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    3 Bulan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-500">
                <i class="ph-bold ph-list-checks text-2xl"></i>
            </div>
            <span class="text-xs font-bold text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg">
                <i class="ph-bold ph-trend-up"></i> +12%
            </span>
        </div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Tugas ({{ $label }})</p>
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalTasks }}</h3>
    </div>

    <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-500">
                <i class="ph-bold ph-check-circle text-2xl"></i>
            </div>
            <span class="text-xs font-bold text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg">
                <i class="ph-bold ph-trend-up"></i> +8%
            </span>
        </div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Selesai ({{ $label }})</p>
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $completedTasks }}</h3>
    </div>

    <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-500">
                <i class="ph-bold ph-clock-countdown text-2xl"></i>
            </div>
            <span class="text-xs font-bold text-orange-500 bg-orange-50 dark:bg-orange-900/20 px-2 py-1 rounded-lg">
                <i class="ph-bold ph-minus"></i> -2%
            </span>
        </div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">In Progress ({{ $label }})</p>
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $inProgressTasks }}</h3>
    </div>

    <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-500/10 flex items-center justify-center text-primary-500">
                <i class="ph-bold ph-percent text-2xl"></i>
            </div>
            <span class="text-xs font-bold text-green-500 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-lg">
                <i class="ph-bold ph-trend-up"></i> +5%
            </span>
        </div>
        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Completion Rate ({{ $label }})</p>
        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $completionRate }}%</h3>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Task Completion Chart -->
    <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Penyelesaian Tugas</h3>
        <div class="h-64"><canvas id="completionChart"></canvas></div>
    </div>

    <!-- Task Priority Distribution -->
    <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Distribusi Prioritas</h3>
        <div class="h-64"><canvas id="priorityChart"></canvas></div>
    </div>
</div>

<!-- Team Performance -->
<div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Performa Tim</h3>
    
    <div class="space-y-4">
        @forelse($teamMembers as $member)
            <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 dark:bg-gray-800">
                <img src="{{ $member->avatar_url }}" class="w-12 h-12 rounded-full border-2 border-white dark:border-gray-700" alt="{{ $member->name }}">
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="font-bold text-gray-900 dark:text-white">{{ $member->name }}</p>
                            <p class="text-xs text-gray-500">{{ $member->role ?? 'Team Member' }}</p>
                        </div>
                        <span class="text-sm font-bold text-primary-500">{{ $member->tasks_count }} tugas</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary-500 h-2 rounded-full" style="width: {{ min(($member->tasks_count / max($teamMembers->max('tasks_count'), 1)) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 dark:text-gray-400 py-8">Belum ada data performa tim</p>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Completion Chart
    const ctxCompletion = document.getElementById('completionChart').getContext('2d');
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? '#334155' : '#e2e8f0';
    const textColor = isDark ? '#94a3b8' : '#64748b';

    new Chart(ctxCompletion, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Tugas Selesai ({{ $label }})',
                data: @json($completionData),
                backgroundColor: '#4900c7',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: gridColor }, ticks: { color: textColor } },
                x: { grid: { display: false }, ticks: { color: textColor } }
            }
        }
    });

    // Priority Chart
    const ctxPriority = document.getElementById('priorityChart').getContext('2d');
    new Chart(ctxPriority, {
        type: 'doughnut',
        data: {
            labels: ['High', 'Medium', 'Low'],
            datasets: [{
                data: [{{ $highPriority }}, {{ $mediumPriority }}, {{ $lowPriority }}],
                backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: textColor, padding: 15, font: { size: 12 } }
                }
            }
        }
    });
</script>
@endpush