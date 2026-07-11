@extends('layouts.app')

@section('title', 'User Settings | AI Workspace')

@section('content')
    <x-slot:title>User Account Settings</x-slot:title>

    <main class="max-w-[1700px] mx-auto w-full h-[calc(100vh-4rem)] flex gap-6 p-6 overflow-hidden bg-[#F8FAFC] antialiased font-sans">
        
        <!-- Inside Core Workspace Container -->
        <div class="flex-grow bg-white border border-slate-200 rounded-2xl flex shadow-sm overflow-hidden h-full w-full">
            
            <!-- 1. Internal Settings Sidebar Menu (Navigation Row) -->
            <aside class="w-[280px] border-r border-slate-200 bg-slate-50/50 p-6 flex flex-col gap-1 shrink-0">
                <div class="mb-4 px-3">
                    <h2 class="text-xs font-mono font-bold text-slate-400 uppercase tracking-widest">Account Dashboard</h2>
                </div>

                <!-- Profile Tab (Active) -->
                <button type="button" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-600 text-white font-bold text-[14px] shadow-sm text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">person</span>
                    <span>Profile Info</span>
                </button>

                <!-- Security Tab -->
                <button type="button" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50 font-bold text-[14px] text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">security</span>
                    <span>Security & Password</span>
                </button>

                <!-- AI Preferences Tab -->
                <button type="button" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50 font-bold text-[14px] text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">auto_awesome</span>
                    <span>AI Preferences</span>
                </button>

                <!-- Notifications Tab -->
                <button type="button" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50 font-bold text-[14px] text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">notifications</span>
                    <span>Notifications</span>
                </button>
            </aside>

            <!-- 2. Settings Core Content Dynamic Area -->
            <section class="flex-grow h-full flex flex-col overflow-hidden">
                
                <!-- Breadcrumb Top Header -->
                <header class="px-8 py-4 border-b border-slate-200 bg-slate-50/30 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                        <span class="text-slate-900 font-extrabold text-[13px]">Settings</span>
                        <span class="material-symbols-outlined text-sm font-black">chevron_right</span>
                        <span>Account</span>
                        <span class="material-symbols-outlined text-sm font-black">chevron_right</span>
                        <span class="text-indigo-600 font-extrabold">Profile Info</span>
                    </div>
                </header>

                <!-- Scrollable Form Panels Container -->
                <div class="flex-1 p-8 overflow-y-auto scrollbar-thin flex flex-col gap-8 bg-white max-w-4xl">
                    
                    <!-- Form 1: Profile Identification Card -->
                    <div class="flex flex-col gap-4">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Personal Profile</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Manage your public account identity, credentials, and digital avatar representation.</p>
                        </div>
                        <div class="h-[1px] bg-slate-100 w-full"></div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-2">
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Full Name</label>
                                <input type="text" value="{{ auth()->user()->name ?? 'User Account' }}" 
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium text-slate-900 shadow-2xs transition-all">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Email Address</label>
                                <input type="email" value="{{ auth()->user()->email ?? 'user@workspace.ai' }}" 
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium text-slate-900 shadow-2xs transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Form 2: AI Automation Tuning (Same Look as Image) -->
                    <div class="flex flex-col gap-4 mt-4">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">AI Workspace Preferences</h3>
                            <p class="text-sm text-slate-500 mt-0.5">Configure how the core LLM engines analyze document streams and generate extraction pipelines.</p>
                        </div>
                        <div class="h-[1px] bg-slate-100 w-full"></div>

                        <!-- Fine-tuning Card Container -->
                        <div class="border border-slate-200 rounded-2xl p-6 bg-slate-50/40 flex flex-col gap-6 shadow-2xs">
                            <!-- Sensitivity Slider Interface -->
                            <div class="flex flex-col gap-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-bold text-slate-800">Automated Analysis Severity</span>
                                    <span class="text-xs font-mono font-extrabold px-2.5 py-0.5 rounded-md bg-indigo-50 border border-indigo-100 text-indigo-700">Balanced (75%)</span>
                                </div>
                                <input type="range" min="1" max="100" value="75" class="w-full accent-indigo-600 h-1.5 bg-slate-200 rounded-lg cursor-pointer">
                                <div class="flex justify-between text-[11px] font-bold text-slate-400 uppercase tracking-wider px-0.5">
                                    <span>Permissive</span>
                                    <span>Balanced</span>
                                    <span>Strict (Precise)</span>
                                </div>
                            </div>

                            <div class="h-[1px] bg-slate-200/60 w-full"></div>

                            <!-- Context Checkboxes Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="flex items-start gap-3 p-4 bg-white border border-slate-200 rounded-xl shadow-2xs cursor-pointer select-none">
                                    <input type="checkbox" checked class="mt-1 w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 accent-indigo-600">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Auto-Extraction Pipelines</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Automatically highlight risk entities instantly upon file upload streams.</p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-3 p-4 bg-white border border-slate-200 rounded-xl shadow-2xs cursor-pointer select-none">
                                    <input type="checkbox" checked class="mt-1 w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 accent-indigo-600">
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">Contextual Prompt Guarding</p>
                                        <p class="text-xs text-slate-400 mt-0.5">Compare user chat inputs against organization standards automatically.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Form 3: Account Integrations Architecture -->
                    <div class="flex flex-col gap-4 mt-4">
                        <div class="flex justify-between items-end">
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Connected Core Gateways</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Link third-party technical software environments and asset deployment web hooks.</p>
                            </div>
                            <button type="button" class="text-xs font-bold text-indigo-600 hover:underline">Explore Marketplace</button>
                        </div>
                        <div class="h-[1px] bg-slate-100 w-full"></div>

                        <!-- Grid Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-1">
                            <!-- Slack Grid Card -->
                            <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-2xs flex flex-col gap-4">
                                <div class="flex justify-between items-start">
                                    <div class="w-9 h-9 bg-rose-50 border border-rose-100 rounded-xl text-rose-600 flex items-center justify-center font-black text-sm">#</div>
                                    <span class="text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 rounded-md">CONNECTED</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Slack Cluster</h4>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Post automated risk alert notifications directly into selected team channels.</p>
                                </div>
                                <button type="button" class="w-full py-1.5 text-xs font-bold border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl shadow-3xs transition-all mt-auto">Configure</button>
                            </div>

                            <!-- Vercel Grid Card -->
                            <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-2xs flex flex-col gap-4">
                                <div class="flex justify-between items-start">
                                    <div class="w-9 h-9 bg-slate-950 rounded-xl text-white flex items-center justify-center font-black text-xs">▲</div>
                                    <span class="text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 rounded-md">CONNECTED</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Vercel Webhooks</h4>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Sync build variables, project deployments, and application env tokens instantly.</p>
                                </div>
                                <button type="button" class="w-full py-1.5 text-xs font-bold border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl shadow-3xs transition-all mt-auto">Configure</button>
                            </div>

                            <!-- Supabase Database Card -->
                            <div class="bg-white border border-slate-200 p-4 rounded-2xl shadow-2xs flex flex-col gap-4">
                                <div class="flex justify-between items-start">
                                    <div class="w-9 h-9 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                                        <span class="material-symbols-outlined text-lg">database</span>
                                    </div>
                                    <span class="text-[10px] font-mono font-bold bg-slate-100 text-slate-600 border border-slate-200 px-2 py-0.5 rounded-md">DISCONNECTED</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Supabase Engine</h4>
                                    <p class="text-xs text-slate-400 mt-1 leading-relaxed">Store vector embedding models and database parsed schemas securely.</p>
                                </div>
                                <button type="button" class="w-full py-1.5 text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm transition-all mt-auto">Connect API</button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer Terminal Console Action Row -->
                <footer class="p-4 border-t border-slate-200 bg-slate-50/80 z-10 flex gap-3 justify-end items-center shrink-0">
                    <button type="button" class="px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-xl text-xs font-bold shadow-2xs transition-all">
                        Discard Changes
                    </button>
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md active:scale-95 transition-all">
                        Save Preferences
                    </button>
                </footer>

            </section>
        </div>
    </main>
@endsection