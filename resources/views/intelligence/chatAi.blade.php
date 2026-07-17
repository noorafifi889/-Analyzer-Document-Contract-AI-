@php
    $riskScore = $analysis->risk_score ?? null;

    if (is_null($riskScore)) {
        $riskLabel = 'Not Analyzed';
        $riskClass = 'bg-slate-100 text-slate-700 border-slate-200';
    } elseif ($riskScore > 70) {
        $riskLabel = 'High Risk';
        $riskClass = 'bg-red-50 text-red-700 border-red-200';
    } elseif ($riskScore > 40) {
        $riskLabel = 'Medium Risk';
        $riskClass = 'bg-amber-50 text-amber-700 border-amber-200';
    } else {
        $riskLabel = 'Low Risk';
        $riskClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
    }
@endphp

@extends('layouts.app')

@section('title', isset($document) && $document ? $document->original_name . ' | AI Workspace' : 'AI Workspace')

@section('content')
    <x-slot:title>AI Document Core - Analysis Center</x-slot:title>

    <main class="max-w-[1700px] mx-auto w-full h-[calc(100vh-4rem)] flex gap-6 p-6 overflow-hidden bg-[#F8FAFC] antialiased font-sans">

        <!-- Left Column: Professional Extracted Text Document Viewer -->
        <section class="hidden lg:flex flex-col w-[42%] bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm h-full">
            <div class="px-5 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50/80 shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <a href="{{ route('intelligence.show', $document) }}"
                       class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-slate-200/80 text-slate-600 transition-colors shrink-0 border border-slate-200 bg-white shadow-xs"
                       title="Back to Document">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                    </a>
                    <div class="min-w-0">
                        <h2 class="text-sm font-bold text-slate-900 truncate max-w-[280px] flex items-center gap-2">
                            <span class="material-symbols-outlined text-slate-400 text-lg">description</span>
                            {{ $document->original_name ?? $document->name ?? 'Uploaded File' }}
                        </h2>
                    </div>
                </div>
                
                {{-- Zoom Controls Component --}}
                <div class="flex items-center gap-1.5 shrink-0 text-slate-400 bg-white border border-slate-200 rounded-xl px-2 py-1 shadow-2xs">
                    <button id="zoom-out-btn" type="button" class="p-1 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors" title="Zoom Out">
                        <span class="material-symbols-outlined text-xl">zoom_out</span>
                    </button>
                    <span id="zoom-level" class="text-xs font-mono font-bold text-slate-600 w-12 text-center select-none">100%</span>
                    <button id="zoom-in-btn" type="button" class="p-1 text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-colors" title="Zoom In">
                        <span class="material-symbols-outlined text-xl">zoom_in</span>
                    </button>
                </div>
            </div>

            {{-- Document Corpus Body --}}
            <div class="p-6 overflow-y-auto bg-slate-100/60 flex-grow scrollbar-thin">
                <div id="doc-text" class="bg-white p-12 shadow-sm border border-slate-200/80 rounded-xl min-h-[900px] whitespace-pre-wrap font-serif text-slate-800 leading-relaxed select-text transition-all duration-150" style="font-size: 15px;" dir="auto">{{ $document->extracted_text ?? 'Notice: No text content was found extracted for this document inside the database storage.' }}</div>
            </div>
        </section>

        <!-- Right Column: AI Analysis & Active Chat Workspace -->
        <section class="flex flex-col flex-grow lg:w-[58%] h-full overflow-hidden">

            {{-- Metric Summary Header Row --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4 shrink-0">
                <div class="bg-white p-4 border border-slate-200 rounded-2xl flex items-center gap-3.5 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 border border-slate-100 flex items-center justify-center shrink-0 shadow-2xs">
                        <span class="material-symbols-outlined text-xl">shield</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-mono font-bold text-slate-400 uppercase tracking-wider">Risk Matrix Status</p>
                        <span class="inline-block text-xs font-extrabold px-2.5 py-0.5 rounded-lg border mt-1 shadow-2xs {{ $riskClass }}">
                            {{ $riskLabel }}
                        </span>
                    </div>
                </div>

                <div class="bg-white p-4 border border-slate-200 rounded-2xl flex items-center gap-3.5 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0 shadow-2xs">
                        <span class="material-symbols-outlined text-xl">fact_check</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-mono font-bold text-slate-400 uppercase tracking-wider">Ingestion Pipeline</p>
                        <p class="text-sm font-extrabold text-indigo-950 mt-1">Parsed Successfully</p>
                    </div>
                </div>

                <div class="bg-white p-4 border border-slate-200 rounded-2xl flex items-center gap-3.5 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0 shadow-2xs">
                        <span class="material-symbols-outlined text-xl">auto_awesome</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-mono font-bold text-slate-400 uppercase tracking-wider">Integrity Index</p>
                        <p class="text-sm font-extrabold text-emerald-950 mt-1">{{ $document->risk_score ?? 94 }}% Stability</p>
                    </div>
                </div>
            </div>

            {{-- Main Chat Dashboard Interface --}}
            <div class="flex-grow bg-white border border-slate-200 rounded-2xl flex flex-col shadow-sm relative overflow-hidden h-full">
                
                <div class="absolute inset-0 opacity-[0.02] pointer-events-none"
                    style="background-image: radial-gradient(#4f46e5 1.5px, transparent 1.5px); background-size: 24px 24px;">
                </div>

                <div class="px-5 py-4 border-b border-slate-200 z-10 flex justify-between items-center bg-slate-50/80 shrink-0">
                    <div class="flex items-center gap-2.5">
                        <div class="w-2.5 h-2.5 rounded-full bg-indigo-600 animate-pulse ring-4 ring-indigo-100"></div>
                        <span class="text-sm font-bold text-slate-900 tracking-tight flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-indigo-500 text-base">smart_toy</span> 
                            File Context Assistant
                        </span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:text-slate-800 hover:bg-slate-50 transition-all shadow-2xs" title="Chat History">
                            <span class="material-symbols-outlined text-lg">history</span>
                        </button>
                    </div>
                </div>

                {{-- Message Streams --}}
                <div class="flex-1 p-6 overflow-y-auto chat-scroll flex flex-col gap-5 z-10 bg-slate-50/50" id="chat-box">

                    <div class="flex justify-center my-2 shrink-0">
                        <span class="bg-indigo-50 text-indigo-700 text-[10px] uppercase font-mono font-bold px-3 py-1 rounded-full tracking-widest border border-indigo-100 shadow-2xs">
                            Active Contextual Session
                        </span>
                    </div>

                    @foreach($chats as $chat)
                        {{-- User Message --}}
                        <div class="flex items-start gap-3 flex-row-reverse max-w-[85%] self-end animate-fade-in-up">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex-shrink-0 flex items-center justify-center text-xs font-black shadow-sm">
                                ME
                            </div>
                            <div class="bg-indigo-600 text-white px-4 py-3 rounded-2xl rounded-tr-none shadow-sm text-[15px] leading-relaxed font-normal">
                                {{ $chat->message }}
                            </div>
                        </div>

                        {{-- AI Message --}}
                        <div class="flex items-start gap-3 max-w-[85%] animate-fade-in-up">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center shadow-2xs">
                                <span class="material-symbols-outlined text-base fill-1">smart_toy</span>
                            </div>
                            <div class="flex flex-col gap-2 max-w-full">
                                <div class="bg-white text-slate-800 px-4 py-3 rounded-2xl rounded-tl-none border border-slate-200 shadow-sm text-[15px] leading-relaxed font-normal" dir="auto">
                                    {{ $chat->response }}

                                    {{-- 🌟 الميزة الجديدة: عرض الاقتباس داخل دبل كوتيشن مخصص ومميز بصرياً --}}
                                    @if(!empty($chat->source_quote))
                                        <div class="mt-3 p-3 bg-amber-50/60 border-l-4 border-amber-400 rounded-r-xl text-xs text-slate-700 italic select-text">
                                            <span class="text-amber-500 font-serif text-lg leading-none">“</span>
                                            {{ $chat->source_quote }}
                                            <span class="text-amber-500 font-serif text-lg leading-none">”</span>
                                        </div>
                                    @endif
                                </div>
                                @if(!empty($chat->source_quote))
                                    <button type="button"
                                        class="show-source-btn self-start inline-flex items-center gap-1.5 text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200/80 rounded-xl px-3 py-1.5 hover:bg-amber-100 transition-colors shadow-2xs"
                                        data-quote="{{ $chat->source_quote }}">
                                        <span class="material-symbols-outlined text-sm">location_on</span>
display source from document 
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Better Fluid Typing Indicator --}}
                    <div class="hidden flex items-start gap-3 max-w-[85%]" id="typing-indicator">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center shadow-2xs">
                            <span class="material-symbols-outlined text-base fill-1">smart_toy</span>
                        </div>
                        <div class="bg-white px-5 py-3.5 rounded-2xl rounded-tl-none border border-slate-200 flex gap-1.5 items-center shadow-xs">
                            <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce [animation-duration:0.9s]"></div>
                            <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce [animation-duration:0.9s] [animation-delay:0.2s]"></div>
                            <div class="w-2 h-2 bg-indigo-600 rounded-full animate-bounce [animation-duration:0.9s] [animation-delay:0.4s]"></div>
                        </div>
                    </div>
                </div>

                {{-- Quick Hints Container --}}
                <div class="px-5 pt-3 pb-2 flex flex-wrap gap-2 z-10 bg-white border-t border-slate-100 shrink-0">
                    <button class="quick-hint-btn text-xs px-3 py-1.5 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 border border-slate-200 rounded-xl text-slate-700 transition-all font-bold shadow-2xs">Summarize core terms</button>
                    <button class="quick-hint-btn text-xs px-3 py-1.5 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 border border-slate-200 rounded-xl text-slate-700 transition-all font-bold shadow-2xs">Are there financial obligations?</button>
                    <button class="quick-hint-btn text-xs px-3 py-1.5 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 border border-slate-200 rounded-xl text-slate-700 transition-all font-bold shadow-2xs">Identify key responsibilities</button>
                </div>

                {{-- Interactive Console Input Area --}}
                <div class="p-4 border-t border-slate-200 bg-slate-50 z-10 flex gap-3 items-center shrink-0">
                    <div class="flex-grow relative bg-white border border-slate-200 rounded-2xl focus-within:ring-4 focus-within:ring-indigo-500/10 focus-within:border-indigo-500 transition-all flex items-center px-4 shadow-2xs">
                        <textarea id="chat-input" rows="1"
                            placeholder="Ask a question based on the document text..."
                            class="w-full resize-none bg-transparent py-3 text-[14px] focus:outline-none text-slate-900 font-medium leading-relaxed max-h-24 chat-scroll"></textarea>
                    </div>
                    <button id="send-btn"
                        class="w-11 h-11 flex items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-md hover:bg-indigo-700 active:scale-95 disabled:opacity-40 transition-all shrink-0">
                        <span class="material-symbols-outlined text-lg font-bold">send</span>
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

        // ============ ZOOM CONTROLS ============
        const docTextEl = document.getElementById('doc-text');
        const zoomInBtn = document.getElementById('zoom-in-btn');
        const zoomOutBtn = document.getElementById('zoom-out-btn');
        const zoomLevelLabel = document.getElementById('zoom-level');
        const baseFontSize = 15; // px
        let zoomPercent = 100;

        function applyZoom() {
            docTextEl.style.fontSize = (baseFontSize * zoomPercent / 100) + 'px';
            zoomLevelLabel.textContent = zoomPercent + '%';
        }

        zoomInBtn.addEventListener('click', function () {
            if (zoomPercent < 200) {
                zoomPercent += 10;
                applyZoom();
            }
        });

        zoomOutBtn.addEventListener('click', function () {
            if (zoomPercent > 60) {
                zoomPercent -= 10;
                applyZoom();
            }
        });

        // ============ SOURCE HIGHLIGHTING ============
        const originalDocText = docTextEl.textContent;

        function escapeHtml(str) {
            return str.replace(/[&<>"']/g, function (m) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m];
            });
        }

        function normalizeSpaces(str) {
            return str.replace(/\s+/g, ' ').trim();
        }

        function highlightQuoteInDocument(quote) {
            if (!quote || !normalizeSpaces(quote)) {
                docTextEl.innerHTML = escapeHtml(originalDocText);
                return;
            }

            const escapedQuote = normalizeSpaces(quote).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const flexiblePattern = escapedQuote.replace(/\s+/g, '\\s+');

            let regex;
            try {
                regex = new RegExp(flexiblePattern, 'i');
            } catch (e) {
                docTextEl.innerHTML = escapeHtml(originalDocText);
                return;
            }

            const match = originalDocText.match(regex);

            if (!match) {
                docTextEl.innerHTML = escapeHtml(originalDocText);
                return;
            }

            const start = match.index;
            const end = start + match[0].length;

            const before = escapeHtml(originalDocText.slice(0, start));
            const matched = escapeHtml(originalDocText.slice(start, end));
            const after = escapeHtml(originalDocText.slice(end));

            docTextEl.innerHTML = before
                + '<mark id="active-highlight" class="bg-amber-200/90 rounded px-0.5 ring-2 ring-amber-400/50 transition-all font-bold text-slate-950">' + matched + '</mark>'
                + after;

            const highlightEl = document.getElementById('active-highlight');
            if (highlightEl) {
                highlightEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function attachSourceButtonListeners(container) {
            container.querySelectorAll('.show-source-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    highlightQuoteInDocument(this.dataset.quote);
                });
            });
        }

        attachSourceButtonListeners(chatBox);

        // ============ CHAT LOGIC ============
        function scrollToBottom() {
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function appendUserMessage(text) {
            const html = `
                <div class="flex items-start gap-3 flex-row-reverse max-w-[85%] self-end animate-fade-in-up">
                    <div class="w-8 h-8 rounded-xl bg-slate-900 text-white flex-shrink-0 flex items-center justify-center text-xs font-black shadow-sm">ME</div>
                    <div class="bg-indigo-600 text-white px-4 py-3 rounded-2xl rounded-tr-none shadow-sm text-[15px] leading-relaxed font-normal">
                        <p></p>
                    </div>
                </div>`;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            wrapper.querySelector('p').textContent = text;
            typingIndicator.before(wrapper.firstElementChild);
        }

        function appendAiMessage(text, quote) {
            const hasQuote = quote && normalizeSpaces(quote);

            // 🌟 نقوم ببناء الـ HTML المخصص لعرض الاقتباس داخل دبل كوتيشن في الرسائل المضافة حياً
            const quoteHtml = hasQuote ? `
                <div class="mt-3 p-3 bg-amber-50/60 border-l-4 border-amber-400 rounded-r-xl text-xs text-slate-700 italic select-text">
                    <span class="text-amber-500 font-serif text-lg leading-none">“</span>
                    ${escapeHtml(quote)}
                    <span class="text-amber-500 font-serif text-lg leading-none">”</span>
                </div>
            ` : '';

            const html = `
                <div class="flex items-start gap-3 max-w-[85%] animate-fade-in-up">
                    <div class="w-8 h-8 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center shadow-2xs">
                        <span class="material-symbols-outlined text-base fill-1">smart_toy</span>
                    </div>
                    <div class="flex flex-col gap-2 max-w-full">
                        <div class="bg-white text-slate-800 px-4 py-3 rounded-2xl rounded-tl-none border border-slate-200 shadow-sm text-[15px] leading-relaxed font-normal">
                            <p></p>
                            ${quoteHtml}
                        </div>
                        ${hasQuote ? `
                        <button type="button" class="show-source-btn self-start inline-flex items-center gap-1.5 text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200/80 rounded-xl px-3 py-1.5 hover:bg-amber-100 transition-colors shadow-2xs">
                            <span class="material-symbols-outlined text-sm">location_on</span>
                            اعرض المصدر بالمستند
                        </button>` : ''}
                    </div>
                </div>`;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            wrapper.querySelector('p').textContent = text;

            if (hasQuote) {
                wrapper.querySelector('.show-source-btn').dataset.quote = quote;
            }

            const el = wrapper.firstElementChild;
            typingIndicator.before(el);
            attachSourceButtonListeners(el);
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
                    appendAiMessage('An error occurred while communicating with the AI cluster. Please check document contents.', null);
                } else {
                    appendAiMessage(data.response, data.quote);
                }
            } catch (err) {
                typingIndicator.classList.add('hidden');
                appendAiMessage('Failed to connect to the gateway backend server.', null);
            } finally {
                sendBtn.disabled = false;
                scrollToBottom();
            }
        }

        document.querySelectorAll('.quick-hint-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                input.value = this.textContent;
                sendMessage();
            });
        });

        input.addEventListener('input', function () {
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

@endsection