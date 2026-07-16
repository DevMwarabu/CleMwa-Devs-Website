<div x-data="customDialog()" 
     x-show="isOpen" 
     style="display: none;"
     class="relative z-[120]" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     @show-dialog.window="openDialog($event.detail)"
     @keydown.escape.window="closeDialog()">
     
    <!-- Background backdrop -->
    <div x-show="isOpen" 
         x-transition:enter="ease-out duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="ease-in duration-200" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" 
         @click="closeDialog()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal panel -->
            <div x-show="isOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative transform overflow-hidden rounded-xl bg-[#0f172a] border border-slate-700 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                
                <div class="bg-[#0f172a] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <!-- Icon -->
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10"
                             :class="iconClass">
                            <i :class="icon"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-bold leading-6 text-white" id="modal-title" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-slate-300 leading-relaxed" x-text="message"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#1e293b]/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-800">
                    <button type="button" 
                            @click="closeDialog()"
                            class="inline-flex w-full justify-center rounded-sm px-6 py-2.5 text-sm font-bold shadow-sm sm:ml-3 sm:w-auto transition-colors"
                            :class="buttonClass"
                            x-text="buttonText">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('customDialog', () => ({
                isOpen: false,
                title: '',
                message: '',
                type: 'info', // info, success, warning, error
                buttonText: 'Got it',
                
                get icon() {
                    switch(this.type) {
                        case 'success': return 'fa-solid fa-check text-green-400 text-xl';
                        case 'warning': return 'fa-solid fa-exclamation text-amber-400 text-xl';
                        case 'error': return 'fa-solid fa-xmark text-red-400 text-xl';
                        default: return 'fa-solid fa-info text-sky-400 text-xl';
                    }
                },
                
                get iconClass() {
                    switch(this.type) {
                        case 'success': return 'bg-green-400/10';
                        case 'warning': return 'bg-amber-400/10';
                        case 'error': return 'bg-red-400/10';
                        default: return 'bg-sky-400/10';
                    }
                },
                
                get buttonClass() {
                    switch(this.type) {
                        case 'success': return 'bg-green-500 hover:bg-green-400 text-slate-900';
                        case 'warning': return 'bg-amber-500 hover:bg-amber-400 text-slate-900';
                        case 'error': return 'bg-red-500 hover:bg-red-400 text-white';
                        default: return 'bg-sky-500 hover:bg-sky-400 text-white';
                    }
                },
                
                openDialog(detail) {
                    this.title = detail.title || 'Notification';
                    this.message = detail.message || '';
                    this.type = detail.type || 'info';
                    this.buttonText = detail.buttonText || 'Got it';
                    this.isOpen = true;
                },
                
                closeDialog() {
                    this.isOpen = false;
                }
            }));
        });
    </script>
</div>
