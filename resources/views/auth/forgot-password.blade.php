<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Lupa Password</h2>
    <p class="text-gray-500 mb-8 text-center">Masukkan email Anda untuk menerima tautan reset password</p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
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
                autofocus
                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-200 focus:border-primary-500 focus:ring-0 text-gray-900 transition-all"
                placeholder="nama@email.com"
            >
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-glow transition-all transform hover:-translate-y-1"
        >
            <i class="ph-bold ph-paper-plane-tilt mr-2"></i>
            Kirim Tautan Reset
        </button>

        <!-- Login Link -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Ingat password Anda? 
            <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-bold">
                Masuk di sini
            </a>
        </p>
    </form>
</x-guest-layout>