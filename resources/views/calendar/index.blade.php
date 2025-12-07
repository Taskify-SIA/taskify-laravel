@extends('layouts.app')

@section('title', 'Kalender')
@section('page-title', 'Kalender')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Kalender</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Jadwal dan agenda penting bulan ini.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
        
        <a href="{{ route('tasks.create') }}" class="flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-glow trans-all transform hover:-translate-y-1">
            <i class="ph-bold ph-plus"></i>
            <span class="hidden sm:inline">Tugas Baru</span>
        </a>
    </div>
</div>

<!-- Calendar Card -->
<div class="bg-white dark:bg-dark-card rounded-[2rem] p-8 shadow-soft border border-gray-100 dark:border-gray-800">
    <!-- Calendar Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ $currentDate->format('F Y') }}
        </h2>
        <div class="flex gap-2">
            <a href="{{ route('calendar.index', ['year' => now()->year, 'month' => now()->month]) }}" 
               class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-white font-medium trans-all">
                Today
            </a>
            <div class="flex bg-gray-100 dark:bg-gray-700 rounded-xl">
                <a href="{{ route('calendar.index', ['year' => $currentDate->copy()->subMonth()->year, 'month' => $currentDate->copy()->subMonth()->month]) }}" 
                   class="px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-l-xl text-gray-700 dark:text-white trans-all">
                    <i class="ph-bold ph-caret-left"></i>
                </a>
                <a href="{{ route('calendar.index', ['year' => $currentDate->copy()->addMonth()->year, 'month' => $currentDate->copy()->addMonth()->month]) }}" 
                   class="px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-r-xl text-gray-700 dark:text-white trans-all">
                    <i class="ph-bold ph-caret-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Calendar Grid Header -->
    <div class="grid grid-cols-7 border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 text-center font-bold text-gray-600 dark:text-gray-400 text-sm">
        <div>Sen</div>
        <div>Sel</div>
        <div>Rab</div>
        <div>Kam</div>
        <div>Jum</div>
        <div>Sab</div>
        <div>Min</div>
    </div>
    
    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 gap-2">
        @foreach($calendarDays as $day)
            <div class="min-h-[100px] p-2 rounded-xl border border-gray-100 dark:border-gray-700 {{ $day['isCurrentMonth'] ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900' }} {{ $day['isToday'] ? 'ring-2 ring-primary-500' : '' }} hover:border-primary-200 dark:hover:border-primary-800 trans-all cursor-pointer group">
                <!-- Day Number -->
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-bold {{ $day['isCurrentMonth'] ? 'text-gray-900 dark:text-white' : 'text-gray-400' }} {{ $day['isToday'] ? 'text-primary-500' : '' }}">
                        {{ $day['dayNumber'] }}
                    </span>
                    @if($day['hasTask'])
                        <span class="w-2 h-2 bg-primary-500 rounded-full"></span>
                    @endif
                </div>
                
                <!-- Tasks for this day -->
                @if($day['tasks']->count() > 0)
                    <div class="space-y-1">
                        @foreach($day['tasks']->take(2) as $task)
                            <div class="text-xs p-1.5 rounded-lg {{ $task->priority === 'high' ? 'bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400' : 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400' }} truncate group-hover:scale-105 trans-all">
                                {{ $task->title }}
                            </div>
                        @endforeach
                        @if($day['tasks']->count() > 2)
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                +{{ $day['tasks']->count() - 2 }} lainnya
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<!-- Upcoming Tasks -->
<div class="mt-8">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Tugas Mendatang</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @php
            $upcomingTasks = Auth::user()->tasks()
                ->where('due_date', '>=', now())
                ->orderBy('due_date', 'asc')
                ->limit(6)
                ->get();
        @endphp
        
        @forelse($upcomingTasks as $task)
            <a href="{{ route('tasks.show', $task) }}" class="block p-4 rounded-2xl bg-white dark:bg-dark-card border border-gray-100 dark:border-gray-800 hover:border-primary-200 dark:hover:border-primary-900 shadow-soft trans-all group">
                <div class="flex items-start justify-between mb-2">
                    <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-primary-500 trans-all flex-1">
                        {{ $task->title }}
                    </h4>
                    @if($task->priority === 'high')
                        <span class="text-red-500"><i class="ph-bold ph-warning"></i></span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                    <i class="ph-bold ph-calendar mr-1"></i>
                    {{ $task->due_date->format('d M Y') }}
                    @if($task->due_time)
                        • {{ $task->due_time }}
                    @endif
                </p>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold {{ $task->status === 'in_progress' ? 'text-orange-500 bg-orange-50 dark:bg-orange-900/20' : 'text-gray-500 bg-gray-50 dark:bg-gray-800' }} px-2 py-1 rounded-lg">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                Tidak ada tugas mendatang
            </div>
        @endforelse
    </div>
</div>
@endsection