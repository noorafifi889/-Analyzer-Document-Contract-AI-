<div x-data="globalChat()" class="relative z-50">
    <button @click="openChat = !openChat" 
        class="fixed bottom-8 right-8 w-14 h-14 bg-indigo-600 text-white rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all flex items-center justify-center z-40">
        <span class="material-symbols-outlined text-2xl" :style="openChat ? 'font-variation-settings: \'FILL\' 0;' : 'font-variation-settings: \'FILL\' 1;'">
            <span x-text="openChat ? 'close' : 'smart_toy'"></span>
        </span>
    </button>

    <div x-show="openChat" x-cloak class="relative z-50" role="dialog" aria-modal="true">
        
        <div x-show="openChat" 
             x-transition:enter="ease-in-out duration-500" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in-out duration-500" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-slate-900/20 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    
                    <div x-show="openChat" 
                         @click.away="openChat = false"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                         x-transition:enter-start="translate-x-full" 
                         x-transition:enter-end="translate-x-0" 
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                         x-transition:leave-start="translate-x-0" 
                         x-transition:leave-end="translate-x-full" 
                         class="pointer-events-auto w-screen max-w-md">
                        
                        <div class="flex h-full flex-col bg-white shadow-2xl">
                            <div class="bg-indigo-600 px-4 py-6 sm:px-6 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-white text-3xl">psychology</span>
                                    <div>
                                        <h2 class="text-base font-bold leading-6 text-white">LexiGuard AI</h2>
                                        <p class="text-xs text-indigo-200">Global Assistant</p>
                                    </div>
                                </div>
                                <button @click="openChat = false" class="text-indigo-200 hover:text-white transition">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>

                            <div id="global-chat-container" class="relative flex-1 px-4 py-6 sm:px-6 overflow-y-auto bg-slate-50 space-y-4">
                                
                                <template x-for="(msg, index) in messages" :key="index">
                                    <div class="flex gap-3" :class="msg.role === 'user' ? 'flex-row-reverse' : ''">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                                             :class="msg.role === 'user' ? 'bg-slate-200 text-slate-600 font-bold text-xs' : 'bg-indigo-100 text-indigo-600'">
                                            <template x-if="msg.role === 'assistant'">
                                                <span class="material-symbols-outlined text-sm">smart_toy</span>
                                            </template>
                                            <template x-if="msg.role === 'user'">
                                                <span class="material-symbols-outlined text-sm">person</span>
                                            </template>
                                        </div>
                                        <div class="p-3 rounded-2xl shadow-sm text-sm"
                                             :class="msg.role === 'user' ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-slate-700 rounded-tl-none border border-slate-100'"
                                             style="white-space: pre-wrap; word-break: break-word;"
                                             x-html="msg.content.replace(/\n/g, '<br>')">
                                        </div>
                                    </div>
                                </template>

                                <div x-show="loading" class="flex gap-3" x-cloak>
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-sm animate-spin">sync</span>
                                    </div>
                                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-sm text-slate-400">
                                        AI is thinking...
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-slate-200 px-4 py-4 sm:px-6 bg-white">
                                <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                                    <input type="text" x-model="input" :disabled="loading" placeholder="Ask me anything..." 
                                           class="block w-full rounded-full border-0 py-2.5 pl-4 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 disabled:bg-slate-50 disabled:text-slate-400">
                                    <button type="submit" :disabled="loading || !input.trim()" 
                                            class="w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center hover:bg-indigo-700 transition shrink-0 disabled:opacity-50 disabled:cursor-not-allowed">
                                        <span class="material-symbols-outlined text-lg">send</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('globalChat', () => ({
            openChat: false,
            loading: false,
            input: '',
            messages: [
                { role: 'assistant', content: 'Hello! I am your AI assistant. Ask me anything, or ask me about the developer of this platform!' }
            ],

            async sendMessage() {
                if (!this.input.trim() || this.loading) return;

                const userText = this.input;
                this.messages.push({ role: 'user', content: userText });
                this.input = '';
                this.loading = true;
                this.scrollToBottom();

                try {
                    const response = await fetch('{{ route("global.chat.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ message: userText })
                    });

                    const data = await response.json();

                    if (response.ok && data.reply) {
                        this.messages.push({ role: 'assistant', content: data.reply });
                    } else {
                        this.messages.push({ role: 'assistant', content: 'Sorry, I encountered an error: ' + (data.error || 'Unknown error') });
                    }
                } catch (error) {
                    console.error('Chat error:', error);
                    this.messages.push({ role: 'assistant', content: 'Connection error. Could not reach the server.' });
                } finally {
                    this.loading = false;
                    this.scrollToBottom();
                }
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('global-chat-container');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                });
            }
        }));
    });
</script>