<div id="logoutModal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm trans-all opacity-0" onclick="closeLogoutModal()"></div>
    
    <div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-dark-card rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 w-full max-w-md p-6 scale-95 opacity-0 trans-all">
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center mb-4">
                <i class="ph-bold ph-sign-out text-2xl text-red-500"></i>
            </div>
            
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Konfirmasi Logout</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Apakah Anda yakin ingin keluar dari aplikasi?</p>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="closeLogoutModal()" 
                        class="flex-1 py-3 px-4 rounded-2xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-white font-medium hover:bg-gray-50 dark:hover:bg-gray-800 trans-all">
                    Batal
                </button>
                
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit" 
                            class="w-full py-3 px-4 rounded-2xl bg-red-500 hover:bg-red-600 text-white font-medium shadow-glow trans-all">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('hidden');
        
        // Trigger animations
        setTimeout(() => {
            modal.querySelector('.fixed.inset-0').classList.remove('opacity-0');
            const modalContent = modal.querySelector('.fixed.top-1\\/2');
            modalContent.classList.remove('scale-95', 'opacity-0');
        }, 10);
    }
    
    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.querySelector('.fixed.inset-0').classList.add('opacity-0');
        const modalContent = modal.querySelector('.fixed.top-1\\/2');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        // Hide modal after animation
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>