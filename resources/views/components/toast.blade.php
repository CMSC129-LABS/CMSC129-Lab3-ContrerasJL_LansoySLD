@if (session('success'))
    <div id="toast"
        class="fixed bottom-6 right-6 z-[9999] flex items-center gap-3 bg-white border-2 border-upv-green rounded-2xl px-5 py-4 shadow-lg transition-all duration-500 translate-y-0 opacity-100">

        <!-- icon -->
        <div class="w-8 h-8 rounded-full bg-upv-green flex items-center justify-center shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12" />
            </svg>
        </div>

        <!-- message -->
        <div class="flex flex-col">
            <span class="text-xs text-gray-400 lowercase tracking-wide">success</span>
            <span class="text-sm font-semibold text-gray-800 font-head">{{ session('success') }}</span>
        </div>

        <!-- close -->
        <button onclick="document.getElementById('toast').remove()"
            class="ml-2 text-gray-300 hover:text-gray-500 text-lg leading-none font-bold">
            ✕
        </button>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(1rem)';
                setTimeout(() => toast.remove(), 500);
            }
        }, 3500);
    </script>
@endif