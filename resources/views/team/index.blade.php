@extends('layouts.app')

@section('title', 'Tim Project')
@section('page-title', 'Tim')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Tim Project</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Anggota tim yang berkolaborasi dengan Anda.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
        
        <a href="{{ route('team.create') }}" class="flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-glow trans-all transform hover:-translate-y-1">
            <i class="ph-bold ph-plus"></i>
            <span class="hidden sm:inline">Tambah Anggota</span>
        </a>
    </div>
</div>

<!-- Team Members Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($teamMembers as $member)
        <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 text-center group hover:border-primary-200 dark:hover:border-primary-900 trans-all">
            <!-- Avatar -->
            <div class="relative inline-block mb-4">
                <img 
                    src="{{ $member->avatar_url }}" 
                    class="w-20 h-20 rounded-full mx-auto border-4 border-primary-50 dark:border-gray-700 group-hover:border-primary-100 dark:group-hover:border-primary-900 trans-all" 
                    alt="{{ $member->name }}"
                >
                <div class="absolute bottom-0 right-0 w-5 h-5 bg-green-500 border-2 border-white dark:border-dark-card rounded-full"></div>
            </div>
            
            <!-- Info -->
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $member->name }}</h3>
            <p class="text-primary-500 text-sm font-medium mb-1">{{ $member->role ?? 'Team Member' }}</p>
            <p class="text-gray-500 dark:text-gray-400 text-xs mb-4">{{ $member->email }}</p>
            
            <!-- Actions -->
            <div class="flex justify-center gap-2 mb-4">
                @if($member->email)
                    <a href="mailto:{{ $member->email }}" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-primary-50 hover:text-primary-500 trans-all">
                        <i class="ph-bold ph-envelope"></i>
                    </a>
                @endif
                
                @if($member->phone)
                    <a href="tel:{{ $member->phone }}" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-primary-50 hover:text-primary-500 trans-all">
                        <i class="ph-bold ph-phone"></i>
                    </a>
                @endif
            </div>

            <!-- Edit/Delete Buttons -->
            <div class="flex gap-2 pt-4 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('team.edit', $member) }}" class="flex-1 py-2 rounded-xl bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary-50 hover:text-primary-500 dark:hover:bg-primary-900/20 text-sm font-medium trans-all">
                    <i class="ph-bold ph-pencil-simple"></i> Edit
                </a>
                <form action="{{ route('team.destroy', $member) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota tim ini?')" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/30 text-sm font-medium trans-all">
                        <i class="ph-bold ph-trash"></i> Hapus
                    </button>
                </form>
            </div>

            <!-- Task Count -->
            <div class="mt-4 p-3 rounded-xl bg-gray-50 dark:bg-gray-800">
                <p class="text-xs text-gray-500 dark:text-gray-400">Terlibat dalam</p>
                <p class="text-2xl font-bold text-primary-500">{{ $member->tasks->count() }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Tugas</p>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white dark:bg-dark-card p-12 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 text-center">
            <i class="ph-duotone ph-users text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Anggota Tim</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Mulai dengan menambahkan anggota tim pertama Anda!</p>
            <a href="{{ route('team.create') }}" class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-glow trans-all">
                <i class="ph-bold ph-plus"></i>
                Tambah Anggota Tim
            </a>
        </div>
    @endforelse
</div>

<!-- Stats -->
@if($teamMembers->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
        <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-500">
                    <i class="ph-bold ph-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Anggota</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teamMembers->count() }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-500">
                    <i class="ph-bold ph-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teamMembers->count() }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-dark-card p-6 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary-50 dark:bg-primary-500/10 flex items-center justify-center text-primary-500">
                    <i class="ph-bold ph-briefcase text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tugas Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $teamMembers->sum(fn($m) => $m->tasks->count()) }}</h3>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection