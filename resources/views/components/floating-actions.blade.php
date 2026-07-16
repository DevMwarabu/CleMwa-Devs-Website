<div x-data="{ 
        scrolled: false, 
        open: false,
        theme: localStorage.getItem('theme') || 'dark',
        toggleTheme() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', this.theme);
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }" 
    @scroll.window="scrolled = (window.pageYOffset > 300)"
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">

    <!-- Secondary Actions (Expandable) -->
    <div class="flex flex-col items-end gap-3 transition-all duration-300 origin-bottom" 
         :class="open ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-90 translate-y-10 pointer-events-none'">
        
        <!-- Back to Top (Only visible when scrolled) -->
        <button x-show="scrolled" x-transition @click="scrollToTop()" class="group relative flex items-center justify-center w-10 h-10 bg-[#0B0B0F] border border-white/10 hover:bg-white/10 hover:border-white/20 text-slate-400 hover:text-white rounded-sm shadow-lg transition-all" aria-label="Back to top">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
            <span class="absolute right-full mr-3 px-2 py-1 bg-[#050507] text-white text-[10px] font-bold uppercase tracking-wider rounded-sm opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-white/10">Top</span>
        </button>

        <!-- Dark/Light Mode -->
        <button @click="toggleTheme()" class="group relative flex items-center justify-center w-10 h-10 bg-[#0B0B0F] border border-white/10 hover:bg-white/10 hover:border-white/20 text-slate-400 hover:text-yellow-400 rounded-sm shadow-lg transition-all" aria-label="Toggle Theme">
            <svg x-show="theme === 'dark'" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            <svg x-show="theme === 'light'" style="display: none;" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            <span class="absolute right-full mr-3 px-2 py-1 bg-[#050507] text-white text-[10px] font-bold uppercase tracking-wider rounded-sm opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-white/10">Theme</span>
        </button>

        <!-- Quick Contact -->
        <a href="/contact" wire:navigate class="group relative flex items-center justify-center w-10 h-10 bg-[#0B0B0F] border border-white/10 hover:bg-white/10 hover:border-white/20 text-slate-400 hover:text-sky-400 rounded-sm shadow-lg transition-all" aria-label="Quick Contact">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            <span class="absolute right-full mr-3 px-2 py-1 bg-[#050507] text-white text-[10px] font-bold uppercase tracking-wider rounded-sm opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-white/10">Contact Us</span>
        </a>

        <!-- WhatsApp Chat -->
        <a href="https://wa.me/254700000000" target="_blank" rel="noopener noreferrer" class="group relative flex items-center justify-center w-10 h-10 bg-[#0B0B0F] border border-emerald-500/30 hover:bg-emerald-500/10 text-emerald-500 hover:text-emerald-400 rounded-sm shadow-lg transition-all shadow-emerald-500/10" aria-label="WhatsApp Chat">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.029 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            <span class="absolute right-full mr-3 px-2 py-1 bg-[#050507] text-white text-[10px] font-bold uppercase tracking-wider rounded-sm opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-emerald-500/20">Chat on WhatsApp</span>
        </a>
    </div>

    <!-- Main FAB / AI Assistant -->
    <button @click="open = !open" class="group relative flex items-center justify-center w-14 h-14 bg-sky-500 hover:bg-sky-400 text-white rounded-sm shadow-[0_0_20px_rgba(14,165,233,0.3)] transition-all hover:scale-105 active:scale-95 border border-sky-400/50" aria-label="Toggle Actions">
        
        <!-- Default State (AI Icon) -->
        <svg x-show="!open" class="w-6 h-6 absolute transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <!-- Sparkles / AI Icon -->
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>

        <!-- Open State (Close Icon) -->
        <svg x-show="open" style="display: none;" class="w-6 h-6 absolute transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>

        <!-- Notification Dot -->
        <span x-show="!open" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 border-2 border-[#0B0B0F] rounded-sm animate-pulse"></span>
        
        <span class="absolute right-full mr-4 px-2 py-1 bg-[#050507] text-white text-[10px] font-bold uppercase tracking-wider rounded-sm opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-white/10" x-text="open ? 'Close' : 'AI Assistant'"></span>
    </button>
</div>
