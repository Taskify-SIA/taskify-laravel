@extends('layouts.app')

@section('title', 'Edit Tugas')
@section('page-title', 'Edit Tugas')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Edit Tugas</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Perbarui informasi tugas Anda.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
        
        <a href="{{ route('tasks.show', $task) }}" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-2xl font-semibold trans-all">
            <i class="ph-bold ph-arrow-left"></i>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="max-w-3xl">
    <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ph-bold ph-text-t mr-1"></i> Judul Tugas <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $task->title) }}"
                    required
                    class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    placeholder="Masukkan judul tugas..."
                >
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ph-bold ph-note-pencil mr-1"></i> Deskripsi
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all resize-none"
                    placeholder="Tambahkan deskripsi tugas (opsional)..."
                >{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status & Priority -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-flag mr-1"></i> Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="status" 
                        name="status"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-warning mr-1"></i> Prioritas <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="priority" 
                        name="priority"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Due Date & Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-calendar mr-1"></i> Tanggal Deadline
                    </label>
                    <input 
                        type="date" 
                        id="due_date" 
                        name="due_date"
                        value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                    @error('due_date')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Due Time -->
                <div>
                    <label for="due_time" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-clock mr-1"></i> Waktu Deadline
                    </label>
                    <input 
                        type="time" 
                        id="due_time" 
                        name="due_time"
                        value="{{ old('due_time', $task->due_time) }}"
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                    @error('due_time')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Team Members -->
            <div class="mb-8">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">
                    <i class="ph-bold ph-users mr-1"></i> Assign ke Tim (opsional)
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse($teamMembers as $member)
                        <label class="flex items-center p-4 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary-500 transition-all">
                            <input 
                                type="checkbox" 
                                name="team_members[]" 
                                value="{{ $member->id }}"
                                {{ in_array($member->id, old('team_members', $task->teamMembers->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500"
                            >
                            <img src="{{ $member->avatar_url }}" class="w-8 h-8 rounded-full ml-3 mr-3" alt="{{ $member->name }}">
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $member->name }}</p>
                                <p class="text-xs text-gray-500">{{ $member->role ?? 'Team Member' }}</p>
                            </div>
                        </label>
                    @empty
                        <p class="col-span-2 text-center text-gray-500 dark:text-gray-400 py-4">
                            Belum ada anggota tim. <a href="{{ route('team.create') }}" class="text-primary-500 hover:text-primary-600 font-bold">Tambah sekarang</a>
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3">
                <button 
                    type="submit"
                    class="flex-1 py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-glow transition-all transform hover:-translate-y-1"
                >
                    <i class="ph-bold ph-floppy-disk mr-2"></i>
                    Simpan Perubahan
                </button>
                <a 
                    href="{{ route('tasks.show', $task) }}"
                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold rounded-xl transition-all"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection