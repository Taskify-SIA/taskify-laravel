<div id="toastContainer" class="fixed bottom-6 right-6 z-50 space-y-3"></div>

<script>
    // Toast notification system
    const toastContainer = document.getElementById('toastContainer');
    
    function showToast(message, type = 'success') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `transform transition-all duration-300 ease-in-out flex items-center p-4 rounded-2xl shadow-lg max-w-md ${
            type === 'success' ? 
            'bg-green-500 text-white' : 
            type === 'error' ? 
            'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        
        // Add icon based on type
        const iconClass = type === 'success' ? 'ph-check-circle' : 
                         type === 'error' ? 'ph-warning' : 
                         'ph-info';
        
        toast.innerHTML = `
            <i class="ph-bold ${iconClass} text-xl mr-3"></i>
            <div class="flex-1 text-sm font-medium">${message}</div>
            <button onclick="this.parentElement.remove()" class="ml-3 text-white/80 hover:text-white">
                <i class="ph-bold ph-x"></i>
            </button>
        `;
        
        // Add to container
        toastContainer.appendChild(toast);
        
        // Trigger entrance animation
        setTimeout(() => {
            toast.classList.add('translate-x-0', 'opacity-100');
        }, 10);
        
        // Auto remove after 3 seconds
        if (type !== 'error') {
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.remove('translate-x-0', 'opacity-100');
                    toast.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(() => {
                        if (toast.parentElement) toast.remove();
                    }, 300);
                }
            }, 3000);
        }
    }
    
    // Check for session messages on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('login_success'))
            showToast("{{ session('login_success') }}", 'success');
        @endif
        
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif
        
        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    });
</script>