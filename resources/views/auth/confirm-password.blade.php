<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Konfirmasi Password</h2>
    <p class="text-gray-500 mb-8 text-center">Ini adalah area aman. Silakan konfirmasi password Anda untuk melanjutkan.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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
                autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-200 focus:border-primary-500 focus:ring-0 text-gray-900 transition-all"
                placeholder="••••••••"
            >
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-glow transition-all transform hover:-translate-y-1"
        >
            <i class="ph-bold ph-check mr-2"></i>
            Konfirmasi
        </button>
    </form>
</x-guest-layout>