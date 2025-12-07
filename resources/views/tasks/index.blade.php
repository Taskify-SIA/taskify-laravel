@extends('layouts.app')

@section('title', 'Tugas Saya')
@section('page-title', 'Tugas')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Tugas Saya</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Kelola semua tugas dan deadline Anda di sini.</p>
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

<!-- Filter Tabs -->
<div class="bg-white dark:bg-dark-card p-1 rounded-2xl inline-flex mb-8 border border-gray-100 dark:border-gray-700">
    <a href="{{ route('tasks.index') }}" class="px-6 py-2 rounded-xl {{ !request('status') || request('status') == 'all' ? 'bg-primary-500 text-white shadow-md' : 'text-gray-500 dark:text-gray-400 hover:text-primary-500' }} text-sm font-bold">Semua</a>
    <a href="{{ route('tasks.index', ['status' => 'pending']) }}" class="px-6 py-2 rounded-xl {{ request('status') == 'pending' ? 'bg-primary-500 text-white shadow-md' : 'text-gray-500 dark:text-gray-400 hover:text-primary-500' }} text-sm font-medium">Pending</a>
    <a href="{{ route('tasks.index', ['status' => 'in_progress']) }}" class="px-6 py-2 rounded-xl {{ request('status') == 'in_progress' ? 'bg-primary-500 text-white shadow-md' : 'text-gray-500 dark:text-gray-400 hover:text-primary-500' }} text-sm font-medium">In Progress</a>
    <a href="{{ route('tasks.index', ['status' => 'completed']) }}" class="px-6 py-2 rounded-xl {{ request('status') == 'completed' ? 'bg-primary-500 text-white shadow-md' : 'text-gray-500 dark:text-gray-400 hover:text-primary-500' }} text-sm font-medium">Selesai</a>
</div>

<!-- Tasks List -->
<div class="space-y-4">
    @forelse($tasks as $task)
        <div class="flex flex-col md:flex-row md:items-center p-6 rounded-[2rem] bg-white dark:bg-dark-card border border-gray-100 dark:border-gray-800 shadow-soft group hover:border-primary-200 dark:hover:border-primary-900 trans-all">
            <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST" class="mb-4 md:mb-0">
                @csrf
                @method('PATCH')
                <label class="custom-checkbox flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only" {{ $task->is_completed ? 'checked' : '' }} onchange="this.form.submit()">
                    <div class="w-6 h-6 border-2 border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center transition-colors">
                        <svg class="w-3 h-3 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </label>
            </form>
            
            <div class="ml-0 md:ml-6 flex-1">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white {{ $task->is_completed ? 'line-through opacity-50' : '' }}">
                    {{ $task->title }}
                </h4>
                <p class="text-gray-500 text-sm mt-1">{{ $task->description ?? 'Tidak ada deskripsi' }}</p>
                <div class="flex items-center gap-4 mt-3">
                    @if($task->teamMembers->count() > 0)
                        <div class="flex -space-x-2">
                            @foreach($task->teamMembers->take(3) as $member)
                                <img class="w-8 h-8 rounded-full border-2 border-white dark:border-dark-card" 
                                     src="{{ $member->avatar_url }}" 
                                     alt="{{ $member->name }}"
                                     title="{{ $member->name }}">
                            @endforeach
                        </div>
                    @endif
                    
                    @if($task->status === 'in_progress')
                        <span class="text-xs font-semibold text-orange-500 bg-orange-50 dark:bg-orange-900/20 px-3 py-1 rounded-lg">In Progress</span>
                    @elseif($task->status === 'completed' || $task->is_completed)
                        <span class="text-xs font-semibold text-green-500 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-lg">Selesai</span>
                    @else
                        <span class="text-xs font-semibold text-gray-500 bg-gray-50 dark:bg-gray-800 px-3 py-1 rounded-lg">Pending</span>
                    @endif
                    
                    @if($task->priority === 'high')
                        <span class="text-xs font-semibold text-red-500 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-lg">High Priority</span>
                    @endif
                </div>
            </div>
            
            <div class="mt-4 md:mt-0 text-right md:mr-4">
                @if($task->due_date)
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        {{ $task->due_date->isToday() ? 'Hari Ini' : ($task->due_date->isTomorrow() ? 'Besok' : $task->due_date->format('d M Y')) }}
                    </p>
                    @if($task->due_time)
                        <p class="text-xs text-gray-400">{{ $task->due_time }}</p>
                    @endif
                @else
                    <p class="text-sm text-gray-400">Tidak ada deadline</p>
                @endif
            </div>
            
            <div class="flex gap-2 mt-4 md:mt-0">
                <a href="{{ route('tasks.show', $task) }}" class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-primary-50 hover:text-primary-500 trans-all">
                    <i class="ph-bold ph-eye"></i>
                </a>
                <a href="{{ route('tasks.edit', $task) }}" class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-primary-50 hover:text-primary-500 trans-all">
                    <i class="ph-bold ph-pencil-simple"></i>
                </a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-red-50 hover:text-red-500 trans-all">
                        <i class="ph-bold ph-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-dark-card p-12 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 text-center">
            <i class="ph-duotone ph-clipboard-text text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Tugas</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Mulai dengan membuat tugas pertama Anda!</p>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-glow trans-all">
                <i class="ph-bold ph-plus"></i>
                Buat Tugas
            </a>
        </div>
    @endforelse
</div>
@endsection