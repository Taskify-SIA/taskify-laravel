@extends('layouts.app')

@section('title', 'Detail Tugas')
@section('page-title', 'Detail Tugas')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Detail Tugas</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Informasi lengkap tentang tugas ini.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
        
        <a href="{{ route('tasks.index') }}" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-2xl font-semibold trans-all">
            <i class="ph-bold ph-arrow-left"></i>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="xl:col-span-2 space-y-6">
        <!-- Task Info Card -->
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $task->title }}</h3>
                    <div class="flex items-center gap-3 flex-wrap">
                        <!-- Status Badge -->
                        @if($task->status === 'in_progress')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-orange-500 bg-orange-50 dark:bg-orange-900/20 px-3 py-1 rounded-lg">
                                <i class="ph-bold ph-clock-countdown"></i> In Progress
                            </span>
                        @elseif($task->status === 'completed' || $task->is_completed)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-500 bg-green-50 dark:bg-green-900/20 px-3 py-1 rounded-lg">
                                <i class="ph-bold ph-check-circle"></i> Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 bg-gray-50 dark:bg-gray-800 px-3 py-1 rounded-lg">
                                <i class="ph-bold ph-circle"></i> Pending
                            </span>
                        @endif
                        
                        <!-- Priority Badge -->
                        @if($task->priority === 'high')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-500 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-lg">
                                <i class="ph-bold ph-warning"></i> High Priority
                            </span>
                        @elseif($task->priority === 'medium')
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-yellow-500 bg-yellow-50 dark:bg-yellow-900/20 px-3 py-1 rounded-lg">
                                <i class="ph-bold ph-flag"></i> Medium Priority
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-500 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-lg">
                                <i class="ph-bold ph-flag"></i> Low Priority
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="p-3 rounded-xl bg-primary-50 dark:bg-primary-900/20 text-primary-500 hover:bg-primary-100 dark:hover:bg-primary-900/30 trans-all">
                        <i class="ph-bold ph-pencil-simple text-lg"></i>
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-3 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/30 trans-all">
                            <i class="ph-bold ph-trash text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Deskripsi</h4>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ $task->description ?? 'Tidak ada deskripsi untuk tugas ini.' }}
                </p>
            </div>

            <!-- Deadline Info -->
            @if($task->due_date)
                <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-500">
                            <i class="ph-bold ph-calendar text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Deadline</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $task->due_date->format('d F Y') }}
                                @if($task->due_time)
                                    <span class="text-sm text-gray-500">pukul {{ $task->due_time }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Complete Toggle -->
            <form action="{{ route('tasks.toggle-complete', $task) }}" method="POST" class="mt-6">
                @csrf
                @method('PATCH')
                <button 
                    type="submit"
                    class="w-full py-3 rounded-xl font-bold trans-all {{ $task->is_completed ? 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200' : 'bg-primary-500 hover:bg-primary-600 text-white shadow-glow' }}"
                >
                    <i class="ph-bold {{ $task->is_completed ? 'ph-arrow-counter-clockwise' : 'ph-check-circle' }} mr-2"></i>
                    {{ $task->is_completed ? 'Tandai Belum Selesai' : 'Tandai Selesai' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Team Members Card -->
        <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="ph-bold ph-users text-primary-500"></i>
                Anggota Tim
            </h3>
            
            @if($task->teamMembers->count() > 0)
                <div class="space-y-3">
                    @foreach($task->teamMembers as $member)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-800">
                            <img src="{{ $member->avatar_url }}" class="w-10 h-10 rounded-full border-2 border-white dark:border-gray-700" alt="{{ $member->name }}">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $member->role ?? 'Team Member' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Belum ada anggota tim yang ditugaskan</p>
            @endif
        </div>

        <!-- Task Meta Info -->
        <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="ph-bold ph-info text-primary-500"></i>
                Informasi Tugas
            </h3>
            
            <div class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Dibuat</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $task->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Terakhir Diubah</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ $task->updated_at->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Status</span>
                    <span class="font-bold text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $task->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Prioritas</span>
                    <span class="font-bold text-gray-900 dark:text-white capitalize">{{ $task->priority }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection