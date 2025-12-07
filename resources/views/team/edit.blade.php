@extends('layouts.app')

@section('title', 'Edit Anggota Tim')
@section('page-title', 'Edit Anggota')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Edit Anggota Tim</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Perbarui informasi anggota tim Anda.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
        
        <a href="{{ route('team.index') }}" class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-6 py-3 rounded-2xl font-semibold trans-all">
            <i class="ph-bold ph-arrow-left"></i>
            <span class="hidden sm:inline">Kembali</span>
        </a>
    </div>
</div>

<!-- Form Card -->
<div class="max-w-2xl">
    <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
        <form action="{{ route('team.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Avatar Upload -->
            <div class="mb-6 text-center">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">
                    <i class="ph-bold ph-user-circle mr-1"></i> Foto Profil
                </label>
                <div class="flex justify-center mb-4">
                    <div class="relative">
                        <img 
                            id="avatar-preview" 
                            src="{{ $teamMember->avatar ? asset('storage/' . $teamMember->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($teamMember->name) . '&background=4900c7&color=fff' }}" 
                            class="w-24 h-24 rounded-full border-4 border-primary-50 dark:border-gray-700 shadow-lg"
                            alt="Avatar Preview"
                        >
                        <label for="avatar" class="absolute bottom-0 right-0 w-8 h-8 bg-primary-500 hover:bg-primary-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-glow trans-all">
                            <i class="ph-bold ph-camera"></i>
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                        </label>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG. Maks 2MB</p>
                @error('avatar')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ph-bold ph-user mr-1"></i> Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $teamMember->name) }}"
                    required
                    class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    placeholder="Masukkan nama lengkap..."
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ph-bold ph-envelope mr-1"></i> Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $teamMember->email) }}"
                    required
                    class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    placeholder="nama@email.com"
                >
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-6">
                <label for="role" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ph-bold ph-briefcase mr-1"></i> Jabatan / Role
                </label>
                <input 
                    type="text" 
                    id="role" 
                    name="role" 
                    value="{{ old('role', $teamMember->role) }}"
                    class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    placeholder="Contoh: Developer, Designer, Project Manager"
                >
                @error('role')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-8">
                <label for="phone" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                    <i class="ph-bold ph-phone mr-1"></i> Nomor Telepon
                </label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    value="{{ old('phone', $teamMember->phone) }}"
                    class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    placeholder="08123456789"
                >
                @error('phone')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3">
                <button 
                    type="submit"
                    class="flex-1 py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-glow transition-all transform hover:-translate-y-1"
                >
                    <i class="ph-bold ph-check mr-2"></i>
                    Simpan Perubahan
                </button>
                <a 
                    href="{{ route('team.index') }}"
                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold rounded-xl transition-all"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush