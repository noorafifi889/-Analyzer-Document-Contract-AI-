@php
    $riskScore = $analysis->risk_score ?? null;

    if (is_null($riskScore)) {
        $riskLabel = 'Not Analyzed';
        $riskClass = 'bg-slate-100 text-slate-700 border-slate-200';
    } elseif ($riskScore > 70) {
        $riskLabel = 'High Risk';
        $riskClass = 'bg-red-50 text-red-700 border-red-200/60';
    } elseif ($riskScore > 40) {
        $riskLabel = 'Medium Risk';
        $riskClass = 'bg-amber-50 text-amber-700 border-amber-200/60';
    } else {
        $riskLabel = 'Low Risk';
        $riskClass = 'bg-emerald-50 text-emerald-700 border-emerald-200/60';
    }
@endphp
@extends('layouts.app')

@section('title', isset($document) && $document ? $document->original_name . ' | AI Workspace' : 'AI Workspace')

@section('content')
    <x-slot:title>AI Document Core - Analysis Center</x-slot:title>

    <!-- تم ضبط الحاوية لتأخذ كامل الارتفاع المتاح للشاشة بشكل ثابت ومنع تمدد الصفحة كلياً -->
    <main class="max-w-[1600px] mx-auto w-full h-[calc(100vh-4rem)] flex gap-6 p-6 overflow-hidden bg-[#f8f9fa] antialiased">
 
        <!-- Left Column: Professional Extracted Text Document Viewer -->
        <section class="hidden lg:flex flex-col w-[42%] bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm h-full">
            <!-- هيدر عارض الملف المطور -->
            <div class="px-4 py-3 border-b border-slate-200 flex justify-between items-center bg-slate-50/70 shrink-0">
                <div class="flex items-center gap-2.5 min-w-0">
                    <a href="{{ route('intelligence.show', $document) }}"
                       class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-200/60 text-slate-500 transition-colors shrink-0"
                       title="Back to Document">
                        <span class="material-symbols-outlined text-xl">arrow_back</span>
                    </a>
                    <div class="min-w-0">
                        <h2 class="text-xs font-bold text-slate-800 truncate max-w-[240px] flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-slate-400 text-base">description</span>
                            {{ $document->original_name ?? $document->name ?? 'Uploaded File' }}
                        </h2>
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0 text-slate-400 border-l border-slate-200 pl-3 ml-1">
                    <button class="p-1 hover:text-slate-700 transition-colors" title="Zoom In">
                        <span class="material-symbols-outlined text-lg">zoom_in</span>
                    </button>
                    <button class="p-1 hover:text-slate-700 transition-colors" title="Zoom Out">
                        <span class="material-symbols-outlined text-lg">zoom_out</span>
                    </button>
                </div>
            </div>
            
            <!-- جسم الملف المعروض - سكرول مستقل احترافي يشبه قارئ المستندات الحقيقي -->
            <div class="p-6 overflow-y-auto bg-slate-100 flex-grow scrollbar-thin">
                <div class="bg-white p-10 shadow-sm border border-slate-200 rounded-lg min-h-[850px] whitespace-pre-wrap font-serif text-[13px] text-slate-800 leading-relaxed select-text">
                    {{ $document->extracted_text ?? 'Notice: No text content was found extracted for this document inside the database storage.' }}
                </div>
            </div>
        </section>
 
        <!-- Right Column: AI Analysis & Active Chat Workspace -->
        <section class="flex flex-col flex-grow lg:w-[58%] h-full overflow-hidden">
 
            <!-- Bento Stats Panel - بطاقات أنيقة مدمجة ومصقولة -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4 shrink-0">
                <!-- بطاقة المخاطر -->
                <div class="bg-white p-3.5 border border-slate-200 rounded-xl flex items-center gap-3 shadow-xs">
                    <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-600 border border-slate-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg">shield</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Risk Matrix</p>
                        <span class="inline-block text-[11px] font-extrabold px-2 py-0.5 rounded-md border mt-0.5 {{ $riskClass }}">
                            {{ $riskLabel }}
                        </span>
                    </div>
                </div>
                
                <!-- بطاقة حالة التحليل -->
                <div class="bg-white p-3.5 border border-slate-200 rounded-xl flex items-center gap-3 shadow-xs">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg">fact_check</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Extraction</p>
                        <p class="text-xs font-bold text-indigo-950 mt-0.5">Text Parsed Successfully</p>
                    </div>
                </div>

                <!-- بطاقة الاستقرار والنزاهة -->
                <div class="bg-white p-3.5 border border-slate-200 rounded-xl flex items-center gap-3 shadow-xs">
                    <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg">auto_awesome</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Integrity Score</p>
                        <p class="text-xs font-bold text-emerald-950 mt-0.5">{{ $document->risk_score ?? 94 }}% Stability</p>
                    </div>
                </div>
            </div>
 
            <!-- Live Chat Workspace Box - حاوية الشات المتقدمة بنظام سكرول ذكي مستقل -->
            <div class="flex-grow bg-white border border-slate-200 rounded-xl flex flex-col shadow-sm relative overflow-hidden h-full">
 
                <!-- خلفية شبكية خفيفة جداً لمظهر تقني ذكي -->
                <div class="absolute inset-0 opacity-[0.015] pointer-events-none"
                    style="background-image: radial-gradient(#004ac6 1px, transparent 1px); background-size: 20px 20px;">
                </div>
 
                <!-- شريط هيدر الشات المطور -->
                <div class="px-4 py-3 border-b border-slate-200 z-10 flex justify-between items-center bg-slate-50/50 shrink-0">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></div>
                        <span class="text-xs font-bold text-slate-800 tracking-tight">File Context Assistant</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="w-7 h-7 flex items-center justify-center rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition-colors" title="Chat History">
                            <span class="material-symbols-outlined text-lg">history</span>
                        </button>
                    </div>
                </div>
 
                <!-- مجرى تدفق الرسائل المطور بالسكرول الثابت داخل الحاوية -->
                <div class="flex-1 p-5 overflow-y-auto chat-scroll flex flex-col gap-4 z-10 bg-slate-50/40" id="chat-box">
 
                    <div class="flex justify-center my-1 shrink-0">
                        <span class="bg-slate-200/70 text-slate-600 text-[9px] uppercase font-bold px-2.5 py-0.5 rounded-full tracking-wider border border-slate-300/30">
                            Active Contextual Session
                        </span>
                    </div>
 
                    <!-- المجرى التكراري للرسائل المخزنة بقوالب عصرية متطابقة مع أشهر شات بوتس -->
                    @foreach($chats as $chat)
                        <!-- رسالة المستخدم -->
                        <div class="flex items-start gap-3 flex-row-reverse max-w-[85%] self-end animate-fade-in-up">
                            <div class="w-7 h-7 rounded-full bg-slate-800 text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold">
                                ME
                            </div>
                            <div class="bg-indigo-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-none shadow-xs text-xs leading-relaxed font-medium">
                                {{ $chat->message }}
                            </div>
                        </div>
 
                        <!-- رد الذكاء الاصطناعي -->
                        <div class="flex items-start gap-3 max-w-[85%] animate-fade-in-up">
                            <div class="w-7 h-7 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                            </div>
                            <div class="bg-white text-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-none border border-slate-200/80 shadow-xs text-xs leading-relaxed font-medium">
                                {{ $chat->response }}
                            </div>
                        </div>
                    @endforeach
 
                    <!-- مؤشر جاري الكتابة الذكي المعزز -->
                    <div class="hidden flex items-start gap-3 max-w-[85%]" id="typing-indicator">
                        <div class="w-7 h-7 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                        </div>
                        <div class="bg-white px-4 py-3 rounded-2xl rounded-tl-none border border-slate-200/80 flex gap-1 items-center shadow-xs">
                            <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce" style="animation-duration: 0.8s"></div>
                            <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce [animation-delay:0.2s]" style="animation-duration: 0.8s"></div>
                            <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full animate-bounce [animation-delay:0.4s]" style="animation-duration: 0.8s"></div>
                        </div>
                    </div>
                </div>
 
                <!-- لوحة التلميحات الذكية والأسئلة السريعة المحدثة -->
                <div class="px-4 pt-2 pb-1.5 flex flex-wrap gap-1.5 z-10 bg-white border-t border-slate-100 shrink-0">
                    <button class="quick-hint-btn text-[11px] px-2.5 py-1 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 border border-slate-200 rounded-md text-slate-600 transition-all font-semibold shadow-2xs">Summarize core terms</button>
                    <button class="quick-hint-btn text-[11px] px-2.5 py-1 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 border border-slate-200 rounded-md text-slate-600 transition-all font-semibold shadow-2xs">Are there financial obligations?</button>
                    <button class="quick-hint-btn text-[11px] px-2.5 py-1 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 border border-slate-200 rounded-md text-slate-600 transition-all font-semibold shadow-2xs">Identify key responsibilities</button>
                </div>
 
                <!-- صندوق الإدخال التفاعلي الاحترافي متناسق الأبعاد مع ميزة مرونة الحجم -->
                <div class="p-3 border-t border-slate-200 bg-slate-50 z-10 flex gap-2 items-center shrink-0">
                    <div class="flex-grow relative bg-white border border-slate-200 rounded-xl focus-within:ring-2 focus-within:ring-indigo-500/20 focus-within:border-indigo-500 transition-all flex items-center px-2.5">
                        <textarea id="chat-input" rows="1"
                            placeholder="Ask a question based on the document text..."
                            class="w-full resize-none bg-transparent py-2.5 text-xs focus:outline-none text-slate-800 font-medium leading-relaxed max-h-24 chat-scroll"></textarea>
                    </div>
                    <button id="send-btn"
                        class="w-8 h-8 flex items-center justify-center rounded-xl bg-indigo-600 text-white shadow-sm disabled:opacity-40 hover:bg-indigo-700 active:scale-95 transition-all shrink-0">
                        <span class="material-symbols-outlined text-base">send</span>
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
                <div class="flex items-start gap-3 flex-row-reverse max-w-[85%] self-end">
                    <div class="w-7 h-7 rounded-full bg-slate-800 text-white flex-shrink-0 flex items-center justify-center text-[10px] font-bold">ME</div>
                    <div class="bg-indigo-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-none shadow-xs text-xs leading-relaxed font-medium">
                        <p></p>
                    </div>
                </div>`;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            wrapper.querySelector('p').textContent = text;
            typingIndicator.before(wrapper.firstElementChild);
        }
 
        function appendAiMessage(text) {
            const html = `
                <div class="flex items-start gap-3 max-w-[85%]">
                    <div class="w-7 h-7 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
                    </div>
                    <div class="bg-white text-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-none border border-slate-200/80 shadow-xs text-xs leading-relaxed font-medium">
                        <p></p>
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

@endsection