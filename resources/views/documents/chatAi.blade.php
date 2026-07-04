
@php
    $riskScore = $analysis->risk_score ?? null;

    if (is_null($riskScore)) {
        $riskLabel = 'Not Analyzed';
        $riskClass = 'text-on-surface-variant';
    } elseif ($riskScore > 70) {
        $riskLabel = 'High Risk';
        $riskClass = 'text-error';
    } elseif ($riskScore > 40) {
        $riskLabel = 'Medium Risk';
        $riskClass = 'text-warning';
    } else {
        $riskLabel = 'Low Risk';
        $riskClass = 'text-success';
    }
@endphp
<x-layouts.app>
    <x-slot:title>AI Document Core - Analysis Center</x-slot:title>

    <main class="flex-grow flex flex-col lg:flex-row max-w-container-max mx-auto w-full px-gutter py-lg gap-lg overflow-hidden">
 
        <!-- Left Column: Extracted Text Document Viewer -->
        <section class="hidden lg:flex flex-col w-2/5 bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden shadow-sm">
            <div class="p-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                <h2 class="font-headline-sm text-headline-sm text-on-surface truncate max-w-[250px]">
                    {{ $document->original_name ?? $document->name ?? 'Uploaded File' }}
                </h2>
                <div class="flex gap-sm">
                    <span class="material-symbols-outlined text-on-surface-variant cursor-pointer select-none" data-icon="zoom_in">zoom_in</span>
                    <span class="material-symbols-outlined text-on-surface-variant cursor-pointer select-none" data-icon="zoom_out">zoom_out</span>
                </div>
            </div>
            <div class="p-xl chat-scroll overflow-y-auto bg-surface-dim/20 flex-grow">
                <div class="space-y-xl text-on-surface-variant">
                    <div class="bg-surface-container-lowest p-xl shadow-sm border border-outline-variant min-h-[800px] whitespace-pre-wrap text-body-md leading-relaxed">
{{ $document->extracted_text ?? 'Notice: No text content was found extracted for this document inside the database storage.' }}
                    </div>
                </div>
            </div>
        </section>
 
        <!-- Right Column: AI Analysis & Active Chat Workspace -->
        <section class="flex flex-col flex-grow lg:w-3/5 h-[calc(100vh-12rem)] min-h-[500px]">
 
            <!-- Bento Stats Panel -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-sm mb-lg">
                <div class="bg-surface-container-lowest p-md border border-outline-variant rounded-xl flex items-center gap-md shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-error-container/20 text-error flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">shield</span>
                    </div>
                    <div>
<div>
    <p class="text-body-sm font-label-md text-on-surface-variant uppercase tracking-wider text-xs">Risk Matrix</p>
    <p class="font-bold {{ $riskClass }}">
        {{ $riskLabel }}
    </p>
</div>
                    </div>
                </div>
                
                <div class="bg-surface-container-lowest p-md border border-outline-variant rounded-xl flex items-center gap-md shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-tertiary-container/30 text-tertiary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">fact_check</span>
                    </div>
                    <div>
                        <p class="text-body-sm font-label-md text-on-surface-variant uppercase tracking-wider text-xs">Extraction</p>
                        <p class="text-tertiary font-bold">Text Parsed</p>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-md border border-outline-variant rounded-xl flex items-center gap-md shadow-sm">
                    <div class="w-10 h-10 rounded-lg bg-secondary-container/30 text-secondary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">auto_awesome</span>
                    </div>
                    <div>
                        <p class="text-body-sm font-label-md text-on-surface-variant uppercase tracking-wider text-xs">Integrity Score</p>
                        <p class="text-secondary font-bold">{{ $document->risk_score ?? 94 }}% Stability</p>
                    </div>
                </div>
            </div>
 
            <!-- Live Chat Workspace Box -->
            <div class="flex-grow bg-surface-container-lowest border border-outline-variant rounded-xl flex flex-col shadow-sm relative overflow-hidden">
 
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
                    style="background-image: radial-gradient(#004ac6 1px, transparent 1px); background-size: 20px 20px;">
                </div>
 
                <!-- Workspace Header -->
                <div class="p-md border-b border-outline-variant glass-panel z-10 flex justify-between items-center bg-surface-container-low/40">
                    <div class="flex items-center gap-sm">
                        <span class="material-symbols-outlined text-primary" data-icon="smart_toy">smart_toy</span>
                        <span class="font-semibold text-on-surface">File Context Assistant</span>
                    </div>
                    <div class="flex gap-sm">
                        <button class="text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined">history</span>
                        </button>
                    </div>
                </div>
 
                <!-- Chat Messaging Stream -->
                <div class="flex-grow p-lg overflow-y-auto chat-scroll flex flex-col gap-lg z-10" id="chat-box">
 
                    <div class="flex justify-center">
                        <span class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-label-md px-md py-1 rounded-full">Active Session</span>
                    </div>
 
                    <!-- Welcome Box -->
                    <div class="flex items-start gap-md max-w-[85%]">
                        <div class="w-8 h-8 rounded-full bg-primary-container flex-shrink-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-primary-container text-sm">smart_toy</span>
                        </div>
                        <div class="bg-surface-container-low text-on-surface-variant p-md rounded-xl rounded-tl-none border border-outline-variant/30">
                            <p class="text-body-md">I have successfully mapped the text converted from your uploaded file. Ask me any direct questions, and I will answer directly using the file's data pool.</p>
                        </div>
                    </div>
 
                    <!-- Historical Database Renders -->
                    @foreach($chats as $chat)
                        <!-- User Chat Row -->
                        <div class="flex items-start gap-md flex-row-reverse max-w-[85%] self-end">
                            <div class="w-8 h-8 rounded-full bg-secondary text-on-secondary flex-shrink-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">person</span>
                            </div>
                            <div class="bg-primary text-on-primary p-md rounded-xl rounded-tr-none shadow-md">
                                <p class="text-body-md">{{ $chat->message }}</p>
                            </div>
                        </div>
 
                        <!-- AI Response Row -->
                        <div class="flex items-start gap-md max-w-[85%]">
                            <div class="w-8 h-8 rounded-full bg-primary-container flex-shrink-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-primary-container text-sm">smart_toy</span>
                            </div>
                            <div class="bg-surface-container-low text-on-surface-variant p-md rounded-xl rounded-tl-none border border-outline-variant/30">
                                <p class="text-body-md">{{ $chat->response }}</p>
                            </div>
                        </div>
                    @endforeach
 
                    <!-- Active Processing Typing Block -->
                    <div class="hidden flex items-start gap-md max-w-[85%]" id="typing-indicator">
                        <div class="w-8 h-8 rounded-full bg-primary-container flex-shrink-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-primary-container text-sm">smart_toy</span>
                        </div>
                        <div class="bg-surface-container-low p-sm rounded-xl rounded-tl-none flex gap-1 items-center min-h-[40px] border border-outline-variant/30">
                            <div class="w-2 h-2 bg-primary/60 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-primary/60 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                            <div class="w-2 h-2 bg-primary/60 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                        </div>
                    </div>
                </div>
 
                <!-- Quick Strategy Hints Panel (English Formatted Queries) -->
                <div class="px-lg pt-sm flex flex-wrap gap-xs z-10 bg-surface-container-lowest">
                    <button class="quick-hint-btn text-xs px-sm py-xs bg-surface-container-low hover:bg-primary/10 border border-outline-variant rounded-full text-on-surface-variant transition-all font-medium">Summarize the core terms</button>
                    <button class="quick-hint-btn text-xs px-sm py-xs bg-surface-container-low hover:bg-primary/10 border border-outline-variant rounded-full text-on-surface-variant transition-all font-medium">Are there any financial obligations?</button>
                    <button class="quick-hint-btn text-xs px-sm py-xs bg-surface-container-low hover:bg-primary/10 border border-outline-variant rounded-full text-on-surface-variant transition-all font-medium">Identify key responsibilities</button>
                </div>
 
                <!-- Input Module Section -->
                <div class="p-md border-t border-outline-variant bg-surface-container-low z-10 flex gap-sm items-end">
                    <textarea id="chat-input" rows="1"
                        placeholder="Type a question based on the uploaded file text..."
                        class="flex-grow resize-none rounded-xl border border-outline-variant bg-surface-container-lowest p-sm text-body-md focus:outline-none focus:ring-2 focus:ring-primary chat-scroll max-h-32"></textarea>
                    <button id="send-btn"
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-primary text-on-primary disabled:opacity-50 hover:opacity-90 active:scale-95 transition-all shrink-0">
                        <span class="material-symbols-outlined">send</span>
                    </button>
                </div>
 
            </div>
        </section>
    </main>
 
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const chatBox = document.getElementById('chat-box');
        const input = document.getElementById('chat-input');
        const sendBtn = document.getElementById('send-btn');
        const typingIndicator = document.getElementById('typing-indicator');
        const sendUrl = "{{ route('documents.chat.send', $document) }}";
        const csrfToken = "{{ csrf_token() }}";
 
        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
 
        function appendUserMessage(text) {
            const html = `
                <div class="flex items-start gap-md flex-row-reverse max-w-[85%] self-end">
                    <div class="w-8 h-8 rounded-full bg-secondary text-on-secondary flex-shrink-0 flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">person</span>
                    </div>
                    <div class="bg-primary text-on-primary p-md rounded-xl rounded-tr-none shadow-md">
                        <p class="text-body-md"></p>
                    </div>
                </div>`;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            wrapper.querySelector('p').textContent = text;
            typingIndicator.before(wrapper.firstElementChild);
        }
 
        function appendAiMessage(text) {
            const html = `
                <div class="flex items-start gap-md max-w-[85%]">
                    <div class="w-8 h-8 rounded-full bg-primary-container flex-shrink-0 flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary-container text-sm">smart_toy</span>
                    </div>
                    <div class="bg-surface-container-low text-on-surface-variant p-md rounded-xl rounded-tl-none border border-outline-variant/30">
                        <p class="text-body-md"></p>
                    </div>
                </div>`;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            wrapper.querySelector('p').textContent = text;
            typingIndicator.before(wrapper.firstElementChild);
        }
 
        async function sendMessage() {
            const message = input.value.trim();
            if (!message) return;
 
            sendBtn.disabled = true;
            appendUserMessage(message);
            input.value = '';
            input.style.height = 'auto'; 
            typingIndicator.classList.remove('hidden');
            scrollToBottom();
 
            try {
                const res = await fetch(sendUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ message })
                });
 
                const data = await res.json();
                typingIndicator.classList.add('hidden');
 
                if (!res.ok || data.error) {
                    appendAiMessage('An error occurred while communicating with the AI cluster. Please check document contents.');
                } else {
                    appendAiMessage(data.response);
                }
            } catch (err) {
                typingIndicator.classList.add('hidden');
                appendAiMessage('Failed to connect to the gateway backend server.');
            } finally {
                sendBtn.disabled = false;
                scrollToBottom();
            }
        }
 
        document.querySelectorAll('.quick-hint-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                input.value = this.textContent;
                sendMessage();
            });
        });

        input.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
 
        scrollToBottom();
    });
    </script>
    @endpush
</x-layouts.app>