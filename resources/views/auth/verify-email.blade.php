<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Verifikasi Email</h2>
    <p class="text-gray-500 mb-8 text-center">Terima kasih telah mendaftar! Silakan periksa email Anda untuk tautan verifikasi.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm">
            Tautan verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button 
                type="submit"
                class="w-full py-3 bg-primary-500 hover:bg-primary-600 text-white font-bold rounded-xl shadow-glow transition-all transform hover:-translate-y-1"
            >
                <i class="ph-bold ph-paper-plane-tilt mr-2"></i>
                Kirim Ulang Email Verifikasi
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button 
                type="submit"
                class="w-full py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all"
            >
                <i class="ph-bold ph-sign-out mr-2"></i>
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>