@props([
    'title' => config('app.name', 'Visit Sukabumi'),
    'text' => 'Jelajahi keindahan dan pesona Sukabumi bersama Visit Sukabumi!',
    'url' => url()->current(),
    'image' => null,
    'buttonClass' => 'flex items-center px-5 py-2 border border-gray-300 rounded-full hover:bg-gray-50 font-bold text-sm transition gap-2 text-gray-700 shadow-sm',
    'buttonText' => 'Bagikan',
    'category' => null,
])

<div x-data="{
    isOpen: false,
    copied: false,
    title: @js($title),
    text: @js($text),
    url: @js($url),
    image: @js($image),
    handleShare() {
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        if (isMobile && navigator.share) {
            navigator.share({
                title: this.title,
                text: this.text,
                url: this.url
            }).catch((err) => {
                if (err.name !== 'AbortError') {
                    this.isOpen = true;
                }
            });
        } else {
            this.isOpen = true;
        }
    },
    copyLink() {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(this.url).then(() => {
                this.triggerCopied();
            }).catch(() => {
                this.fallbackCopy();
            });
        } else {
            this.fallbackCopy();
        }
    },
    fallbackCopy() {
        if (this.$refs.urlInput) {
            this.$refs.urlInput.select();
            this.$refs.urlInput.setSelectionRange(0, 99999);
            document.execCommand('copy');
            this.triggerCopied();
        }
    },
    triggerCopied() {
        this.copied = true;
        setTimeout(() => {
            this.copied = false;
        }, 2500);
    },
    shareTo(platform) {
        const shareUrl = encodeURIComponent(this.url);
        const shareText = encodeURIComponent(this.text);
        let link = '';
        
        switch(platform) {
            case 'whatsapp':
                link = `https://api.whatsapp.com/send?text=${shareText}%20${shareUrl}`;
                break;
            case 'facebook':
                link = `https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`;
                break;
            case 'twitter':
                link = `https://twitter.com/intent/tweet?text=${shareText}&url=${shareUrl}`;
                break;
            case 'telegram':
                link = `https://t.me/share/url?url=${shareUrl}&text=${shareText}`;
                break;
        }
        
        if (link) {
            window.open(link, '_blank', 'noopener,noreferrer,width=600,height=500');
        }
    }
}" class="inline-block">

    {{-- Trigger Button --}}
    <button type="button" @click="handleShare()" class="{{ $buttonClass }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
        </svg>
        <span>{{ $buttonText }}</span>
    </button>

    {{-- Teleported Modal (Desktop & Fallback) --}}
    <template x-teleport="body">
        <div x-show="isOpen" 
             x-cloak
             @keydown.escape.window="isOpen = false"
             class="fixed inset-0 z-[999] overflow-y-auto" 
             role="dialog" 
             aria-modal="true">
             
            {{-- Backdrop --}}
            <div x-show="isOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="isOpen = false"
                 class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>

            {{-- Modal Dialog Container --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div x-show="isOpen"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     @click.stop
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-md border border-gray-100 p-6 sm:p-7">
                    
                    {{-- Header & Close Button --}}
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-full bg-emerald-50 text-[#00aa6c] flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 tracking-tight">Bagikan ke Teman</h3>
                        </div>
                        <button type="button" @click="isOpen = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-full hover:bg-gray-100 transition">
                            <span class="sr-only">Tutup</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Item Preview Card --}}
                    <div class="my-5 p-3.5 bg-gray-50 rounded-2xl border border-gray-100 flex items-center gap-3.5">
                        <template x-if="image">
                            <img :src="image" :alt="title" class="w-16 h-16 rounded-xl object-cover flex-shrink-0 shadow-xs border border-gray-200/60">
                        </template>
                        <div class="min-w-0 flex-1">
                            @if($category)
                                <span class="inline-block px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wider bg-emerald-100/70 text-emerald-800 rounded-md mb-1">{{ $category }}</span>
                            @endif
                            <h4 class="text-sm font-bold text-gray-900 line-clamp-1" x-text="title"></h4>
                            <p class="text-xs text-gray-500 line-clamp-2 mt-0.5 leading-relaxed" x-text="text"></p>
                        </div>
                    </div>

                    {{-- Share Social Options --}}
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-3">Pilih Media Sosial</span>
                            <div class="grid grid-cols-4 gap-3 text-center">
                                {{-- WhatsApp --}}
                                <button type="button" @click="shareTo('whatsapp')" class="group flex flex-col items-center gap-1.5 focus:outline-none">
                                    <div class="w-12 h-12 rounded-2xl bg-[#25D366]/10 text-[#25D366] flex items-center justify-center group-hover:bg-[#25D366] group-hover:text-white transition-all shadow-xs group-hover:scale-105">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.35.49 1.199.534 1.286.044.087.073.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.073.376-.044c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086.159.058 1.011.477 1.184.564.173.087.289.13.332.203.043.072.043.419-.101.824z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">WhatsApp</span>
                                </button>

                                {{-- Facebook --}}
                                <button type="button" @click="shareTo('facebook')" class="group flex flex-col items-center gap-1.5 focus:outline-none">
                                    <div class="w-12 h-12 rounded-2xl bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center group-hover:bg-[#1877F2] group-hover:text-white transition-all shadow-xs group-hover:scale-105">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">Facebook</span>
                                </button>

                                {{-- X / Twitter --}}
                                <button type="button" @click="shareTo('twitter')" class="group flex flex-col items-center gap-1.5 focus:outline-none">
                                    <div class="w-12 h-12 rounded-2xl bg-black/10 text-black flex items-center justify-center group-hover:bg-black group-hover:text-white transition-all shadow-xs group-hover:scale-105">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 22.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">X</span>
                                </button>

                                {{-- Telegram --}}
                                <button type="button" @click="shareTo('telegram')" class="group flex flex-col items-center gap-1.5 focus:outline-none">
                                    <div class="w-12 h-12 rounded-2xl bg-[#229ED9]/10 text-[#229ED9] flex items-center justify-center group-hover:bg-[#229ED9] group-hover:text-white transition-all shadow-xs group-hover:scale-105">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">Telegram</span>
                                </button>
                            </div>
                        </div>

                        {{-- Copy Link Box --}}
                        <div class="pt-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-400 block mb-2">Salin Tautan</label>
                            <div class="flex items-center gap-2 p-1.5 bg-gray-50 border border-gray-200 rounded-2xl focus-within:border-[#00aa6c] focus-within:ring-2 focus-within:ring-[#00aa6c]/20 transition-all">
                                <div class="pl-2.5 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                </div>
                                <input type="text" 
                                       readonly 
                                       x-ref="urlInput"
                                       :value="url" 
                                       class="w-full bg-transparent text-xs sm:text-sm text-gray-700 focus:outline-none truncate font-medium">
                                <button type="button" 
                                        @click="copyLink()" 
                                        :class="copied ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-gray-900 hover:bg-black text-white'"
                                        class="flex-shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-xs">
                                    <template x-if="!copied">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            Salin
                                        </span>
                                    </template>
                                    <template x-if="copied">
                                        <span class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Tersalin!
                                        </span>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </template>
</div>
