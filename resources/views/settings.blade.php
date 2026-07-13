@extends('layouts.app')

@section('title', 'User Settings | AI Workspace')

@section('content')
    <x-slot:title>User Account Settings</x-slot:title>

    <main x-data="{ currentTab: 'profile' }" class="w-full min-h-screen bg-slate-50/50  antialiased font-sans">
        <div class="max-w-7xl space-y-8">
            
            <!-- Header Section -->
            <div class="flex flex-col gap-1.5">
                <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 tracking-tight">Account Workspace Settings</h1>
                <p class="text-xs md:text-sm text-slate-500">Manage your profile identities, security credentials, and Core AI pipeline configurations.</p>
            </div>

            <!-- Tabs Navigation -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-1.5 shadow-xs flex gap-1 overflow-x-auto scrollbar-none">
                <button type="button" @click="currentTab = 'profile'"
                    :class="currentTab === 'profile' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-xs md:text-sm transition-all duration-200 shrink-0 flex-1">
                    <span class="material-symbols-outlined text-lg">person</span>
                    <span>Profile Info</span>
                </button>

                <button type="button" @click="currentTab = 'security'"
                    :class="currentTab === 'security' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-xs md:text-sm transition-all duration-200 shrink-0 flex-1">
                    <span class="material-symbols-outlined text-lg">security</span>
                    <span>Security & Password</span>
                </button>

                <button type="button" @click="currentTab = 'ai'"
                    :class="currentTab === 'ai' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50'"
                    class="flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-xs md:text-sm transition-all duration-200 shrink-0 flex-1">
                    <span class="material-symbols-outlined text-lg">auto_awesome</span>
                    <span>AI Preferences</span>
                </button>
            </div>

            <!-- Settings Update Form -->
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                @if (session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl text-xs md:text-sm font-semibold flex items-center gap-3 shadow-xs">
                        <span class="material-symbols-outlined text-emerald-600 text-lg">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ================= TAB 1: PROFILE INFO ================= -->
                <div x-show="currentTab === 'profile'" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-8">
                    
                    <!-- Section 1: Profile -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 space-y-6 shadow-xs">
                        <div>
                            <h3 class="text-base md:text-lg font-bold text-slate-900 tracking-tight">Personal Profile</h3>
                            <p class="text-xs text-slate-500 mt-1">Manage your public account identity, credentials, and digital representation.</p>
                        </div>
                        <div class="h-[1px] bg-slate-100 w-full"></div>

                        <!-- Avatar Upload -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 p-5 bg-slate-50/70 border border-slate-100 rounded-2xl">
                            <div class="relative w-20 h-20 rounded-2xl bg-indigo-50 border border-slate-200 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                                @if (auth()->user() && auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover" id="avatar_preview">
                                @else
                                    <span class="text-xl font-bold text-indigo-600 uppercase" id="avatar_placeholder">
                                        {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                                    </span>
                                @endif
                            </div>
                            <div class="space-y-2">
                                <span class="text-xs font-bold text-slate-800">Profile Picture</span>
                                <div class="flex flex-wrap items-center gap-3">
                                    <label class="px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-xs font-bold shadow-xs cursor-pointer transition-all active:scale-95">
                                        Choose new file
                                        <input type="file" name="avatar" accept="image/*" class="hidden">
                                    </label>
                                    <p class="text-[11px] text-slate-400">Supports PNG, JPG or WEBP up to 2MB.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Inputs Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Full Name</label>
                                <input type="text" name="name" value="{{ auth()->user()->name ?? 'User Account' }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-xs md:text-sm font-semibold text-slate-900 shadow-xs transition-all outline-none">
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Email Address</label>
                                <input type="email" name="email" value="{{ auth()->user()->email ?? 'user@workspace.ai' }}"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-xs md:text-sm font-semibold text-slate-900 shadow-xs transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Gateways -->
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 space-y-6 shadow-xs">
                        <div>
                            <h3 class="text-base md:text-lg font-bold text-slate-900 tracking-tight">Connected Core Gateways</h3>
                            <p class="text-xs text-slate-500 mt-1">Link third-party technical software environments and core analytical APIs.</p>
                        </div>
                        <div class="h-[1px] bg-slate-100 w-full"></div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Slack -->
                            <div class="bg-slate-50/50 border border-slate-100 p-6 rounded-2xl flex flex-col justify-between gap-6 hover:border-slate-200 transition-all">
                                <div class="flex justify-between items-start">
                                    <div class="w-10 h-10 bg-rose-50 text-rose-600 flex items-center justify-center font-extrabold text-base rounded-xl">#</div>
                                    <span class="text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-100 px-2.5 py-1 rounded-md tracking-wider uppercase">CONNECTED</span>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xs md:text-sm font-bold text-slate-800">Slack Cluster</h4>
                                    <p class="text-[11px] text-slate-400">Stream analysis events directly into workspace channels.</p>
                                </div>
                                <button type="button" class="w-full py-2.5 text-xs font-bold border border-slate-200 bg-white text-slate-700 rounded-xl hover:bg-slate-50 transition-all shadow-2xs">Configure</button>
                            </div>

                            <!-- Vercel -->
                            <div class="bg-slate-50/50 border border-slate-100 p-6 rounded-2xl flex flex-col justify-between gap-6 hover:border-slate-200 transition-all">
                                <div class="flex justify-between items-start">
                                    <div class="w-10 h-10 bg-slate-900 text-white flex items-center justify-center text-sm rounded-xl">▲</div>
                                    <span class="text-[9px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-100 px-2.5 py-1 rounded-md tracking-wider uppercase">CONNECTED</span>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xs md:text-sm font-bold text-slate-800">Vercel Webhooks</h4>
                                    <p class="text-[11px] text-slate-400">Deploy dynamic models and triggers via webhooks.</p>
                                </div>
                                <button type="button" class="w-full py-2.5 text-xs font-bold border border-slate-200 bg-white text-slate-700 rounded-xl hover:bg-slate-50 transition-all shadow-2xs">Configure</button>
                            </div>

                            <!-- Supabase -->
                            <div class="bg-slate-50/50 border border-slate-100 p-6 rounded-2xl flex flex-col justify-between gap-6 hover:border-slate-200 transition-all">
                                <div class="flex justify-between items-start">
                                    <div class="w-10 h-10 bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center rounded-xl">
                                        <span class="material-symbols-outlined text-lg">database</span>
                                    </div>
                                    <span class="text-[9px] font-extrabold bg-slate-100 text-slate-500 border border-slate-200 px-2.5 py-1 rounded-md tracking-wider uppercase">DISCONNECTED</span>
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xs md:text-sm font-bold text-slate-800">Supabase Engine</h4>
                                    <p class="text-[11px] text-slate-400">Sync Vector embeddings database directly with Postgres.</p>
                                </div>
                                <button type="button" class="w-full py-2.5 text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md shadow-indigo-600/10 transition-all">Connect API</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 2: SECURITY ================= -->
                <div x-show="currentTab === 'security'" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-8">
                    
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 space-y-6 shadow-xs">
                        <div>
                            <h3 class="text-base md:text-lg font-bold text-slate-900 tracking-tight">Security & Encryption</h3>
                            <p class="text-xs text-slate-500 mt-1">Update your credentials to safeguard your LLM and data workspaces.</p>
                        </div>
                        <div class="h-[1px] bg-slate-100 w-full"></div>

                        <div class="space-y-5">
                            <div class="flex flex-col gap-2">
                                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Current Password</label>
                                <input type="password" name="current_password" placeholder="••••••••"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-xs md:text-sm font-semibold text-slate-900 shadow-xs transition-all outline-none">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">New Password</label>
                                    <input type="password" name="new_password" placeholder="••••••••"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-xs md:text-sm font-semibold text-slate-900 shadow-xs transition-all outline-none">
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wider">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" placeholder="••••••••"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-xs md:text-sm font-semibold text-slate-900 shadow-xs transition-all outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <div class="border border-rose-100 bg-rose-50/20 rounded-3xl p-6 md:p-8 space-y-6">
                        <div>
                            <h3 class="text-base md:text-lg font-bold text-rose-600 tracking-tight flex items-center gap-2">
                                <span class="material-symbols-outlined text-lg">warning</span> Danger Zone
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">Permanently delete your account, trained vector pipelines, and activity logs.</p>
                        </div>
                        <div class="h-[1px] bg-rose-100/50 w-full"></div>
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="space-y-0.5">
                                <span class="text-xs md:text-sm font-bold text-slate-700">Delete Account Workspace</span>
                                <p class="text-[11px] text-slate-400">Once deleted, this action is permanent and cannot be reversed.</p>
                            </div>
                            <button type="button" onclick="confirmDeleteAccount()"
                                class="w-full sm:w-auto px-5 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md shadow-rose-600/10 transition-all hover:scale-[0.99] active:scale-95">
                                Delete Account Permanently
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ================= TAB 3: AI PREFERENCES ================= -->
                <div x-show="currentTab === 'ai'" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-8">
                    
                    <div class="bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 space-y-6 shadow-xs">
                        <div>
                            <h3 class="text-base md:text-lg font-bold text-slate-900 tracking-tight">AI Workspace Preferences</h3>
                            <p class="text-xs text-slate-500 mt-1">Configure parameters governing LLM-model analytical and contextual processing limits.</p>
                        </div>
                        <div class="h-[1px] bg-slate-100 w-full"></div>

                        <div class="space-y-6">
                            <!-- Slider Block -->
                            <div class="flex flex-col gap-4 p-5 bg-slate-50/50 border border-slate-100 rounded-2xl">
                                <div class="flex justify-between items-center">
                                    <div class="space-y-0.5">
                                        <span class="text-xs md:text-sm font-bold text-slate-800">Automated Analysis Severity</span>
                                        <p class="text-[11px] text-slate-400">Threshold adjustments for LLM extraction and summarization.</p>
                                    </div>
                                    <span class="text-[10px] font-mono font-extrabold px-3 py-1 rounded-lg bg-indigo-50 border border-indigo-100 text-indigo-700">Balanced (75%)</span>
                                </div>
                                <input type="range" name="ai_severity" min="1" max="100" value="75"
                                    class="w-full accent-indigo-600 h-1.5 bg-slate-200 rounded-lg cursor-pointer">
                            </div>

                            <!-- Checkboxes Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="flex items-start gap-4 p-5 bg-slate-50/30 border border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all select-none">
                                    <input type="checkbox" name="auto_extract" value="1" checked
                                        class="mt-1 w-4 h-4 text-indigo-600 rounded accent-indigo-600 border-slate-300 focus:ring-indigo-500">
                                    <div>
                                        <p class="text-xs md:text-sm font-bold text-slate-800">Auto-Extraction Pipelines</p>
                                        <p class="text-[11px] text-slate-400 mt-1">Automatically trigger analytical parser services on document imports.</p>
                                    </div>
                                </label>

                                <label class="flex items-start gap-4 p-5 bg-slate-50/30 border border-slate-100 rounded-2xl cursor-pointer hover:bg-slate-50 transition-all select-none">
                                    <input type="checkbox" name="prompt_guarding" value="1" checked
                                        class="mt-1 w-4 h-4 text-indigo-600 rounded accent-indigo-600 border-slate-300 focus:ring-indigo-500">
                                    <div>
                                        <p class="text-xs md:text-sm font-bold text-slate-800">Contextual Prompt Guarding</p>
                                        <p class="text-[11px] text-slate-400 mt-1">Dynamically filter downstream pipelines against vector-injections.</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Action Buttons (Fixed Bottom/Responsive spacing) -->
                <div class="flex flex-col sm:flex-row gap-3 justify-end items-center pt-6 border-t border-slate-200/60">
                    <button type="button" @click="window.location.reload()"
                        class="w-full sm:w-auto px-6 py-3 border border-slate-200 text-slate-700 bg-white hover:bg-slate-50 rounded-xl text-xs font-bold shadow-xs transition-all active:scale-95">
                        Discard Changes
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto px-7 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-600/10 transition-all hover:scale-[0.99] active:scale-95">
                        Save Workspace Settings
                    </button>
                </div>

            </form>

            <!-- Hidden delete account form for security -->
            <form id="delete-account-form" action="{{ route('settings.destroy') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </main>

    <script>
        function confirmDeleteAccount() {
            if (confirm("🚨 هل أنت متأكد تماماً من رغبتك في حذف حسابك؟ هذا الإجراء سيقوم بمسح كافة ملفاتك وقواعد البيانات الخاصة بك نهائياً ولا يمكن الرجوع عنه!")) {
                document.getElementById('delete-account-form').submit();
            }
        }
        if (typeof Alpine === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer><\/script>');
        }
    </script>
@endsection