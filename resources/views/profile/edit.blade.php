@extends('layouts.app')

@section('title', 'Pengaturan Profil')
@section('page-title', 'Pengaturan')

@section('content')
<!-- TOP BAR -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
    <div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Pengaturan</h2>
        <p class="text-gray-500 dark:text-dark-muted mt-1">Atur preferensi akun dan tampilan.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="toggleDarkMode()" class="px-4 py-3 rounded-2xl bg-white dark:bg-dark-card shadow-soft border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-primary-500 trans-all">
            <i id="themeIcon" class="ph-bold ph-moon"></i>
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Photo Card -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800 text-center sticky top-8">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Foto Profil</h3>
            
            <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" id="photoForm">
                @csrf
                @method('PATCH')
                
                <div class="mb-6">
                    <div class="relative inline-block">
                        <img 
                            id="profile-photo-preview" 
                            src="{{ Auth::user()->profile_photo_url }}" 
                            class="w-32 h-32 rounded-full mx-auto border-4 border-primary-50 dark:border-gray-700 shadow-lg"
                            alt="{{ Auth::user()->name }}"
                        >
                        <label for="profile_photo" class="absolute bottom-0 right-0 w-10 h-10 bg-primary-500 hover:bg-primary-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-glow trans-all">
                            <i class="ph-bold ph-camera"></i>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewAndSubmitPhoto(event)">
                        </label>
                    </div>
                </div>
                
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                    Klik ikon kamera untuk mengubah foto<br>
                    Format: JPG, PNG. Maks 2MB
                </p>
                
                @error('profile_photo')
                    <p class="text-sm text-red-600 dark:text-red-400 mb-4">{{ $message }}</p>
                @enderror
            </form>

            <div class="pt-6 border-t border-gray-100 dark:border-gray-700">
                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Profile Settings -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Personal Information -->
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Informasi Pribadi</h3>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-user mr-1"></i> Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', Auth::user()->name) }}"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-envelope mr-1"></i> Email
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', Auth::user()->email) }}"
                        required
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <button 
                    type="submit"
                    class="w-full py-3 rounded-xl bg-primary-500 text-white font-bold shadow-glow hover:bg-primary-600 trans-all"
                >
                    <i class="ph-bold ph-floppy-disk mr-2"></i>
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Ubah Password</h3>
            
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Current Password -->
                <div class="mb-6">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-lock mr-1"></i> Password Saat Ini
                    </label>
                    <input 
                        type="password" 
                        id="current_password" 
                        name="current_password"
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                    @error('current_password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-lock mr-1"></i> Password Baru
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="ph-bold ph-lock mr-1"></i> Konfirmasi Password Baru
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        class="w-full px-4 py-3 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white transition-all"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full py-3 rounded-xl bg-primary-500 text-white font-bold shadow-glow hover:bg-primary-600 trans-all"
                >
                    <i class="ph-bold ph-shield-check mr-2"></i>
                    Update Password
                </button>
            </form>
        </div>

        <!-- Preferences -->
        <div class="bg-white dark:bg-dark-card p-8 rounded-[2rem] shadow-soft border border-gray-100 dark:border-gray-800">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Preferensi</h3>
            
            <div class="space-y-4">
                <!-- Email Notifications -->
                <div class="flex items-center justify-between py-4 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Notifikasi Email</h4>
                        <p class="text-xs text-gray-500">Terima update harian tentang tugas.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-500"></div>
                    </label>
                </div>

                <!-- Dark Mode -->
                <div class="flex items-center justify-between py-4 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Mode Gelap</h4>
                        <p class="text-xs text-gray-500">Tampilan dengan latar belakang gelap.</p>
                    </div>
                    <button onclick="toggleDarkMode()" class="px-4 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600 trans-all">
                        <i class="ph-bold ph-moon dark:ph-sun"></i>
                    </button>
                </div>

                <!-- Language -->
                <div class="flex items-center justify-between py-4">
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Bahasa</h4>
                        <p class="text-xs text-gray-500">Pilih bahasa tampilan aplikasi.</p>
                    </div>
                    <select class="px-4 py-2 rounded-xl bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 focus:border-primary-500 focus:ring-0 text-gray-900 dark:text-white">
                        <option>Indonesia</option>
                        <option>English</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-red-50 dark:bg-red-900/20 p-8 rounded-[2rem] border-2 border-red-200 dark:border-red-800">
            <h3 class="text-xl font-bold text-red-600 dark:text-red-400 mb-4">Zona Berbahaya</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-6">
                Setelah akun Anda dihapus, semua data dan resources akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.
            </p>
            <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button 
                    type="submit"
                    class="px-6 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold trans-all"
                >
                    <i class="ph-bold ph-trash mr-2"></i>
                    Hapus Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewAndSubmitPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            // Preview
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-photo-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            // Auto submit
            document.getElementById('photoForm').submit();
        }
    }
</script>
@endpush