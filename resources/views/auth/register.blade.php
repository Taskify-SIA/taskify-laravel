<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Buat Akun Baru</h2>
    <p class="text-gray-500 mb-8 text-center">Silakan daftar untuk memulai</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                <i class="ph-bold ph-user mr-1"></i> Nama Lengkap
            </label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                autofocus 
                autocomplete="name"
                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-200 focus:border-primary-500 focus:ring-0 text-gray-900 transition-all"
                placeholder="Nama lengkap Anda"
            >
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                <i class="ph-bold ph-envelope mr-1"></i> Email
            </label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autocomplete="username"
                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-200 focus:border-primary-500 focus:ring-0 text-gray-900 transition-all"
                placeholder="nama@email.com"
            >
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                <i class="ph-bold ph-lock mr-1"></i> Password
            </label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-200 focus:border-primary-500 focus:ring-0 text-gray-900 transition-all"
                placeholder="••••••••"
            >
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                <i class="ph-bold ph-lock mr-1"></i> Konfirmasi Password
            </label>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-200 focus:border-primary-500 focus:ring-0 text-gray-900 transition-all"
                placeholder="••••••••"
            >
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-glow transition-all transform hover:-translate-y-1"
        >
            <i class="ph-bold ph-user-plus mr-2"></i>
            Daftar
        </button>

        <!-- Login Link -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-bold">
                Masuk di sini
            </a>
        </p>
    </form>
</x-guest-layout>