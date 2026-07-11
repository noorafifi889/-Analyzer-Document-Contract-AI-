@extends('layouts.app')

@section('title', 'User Settings | AI Workspace')

@section('content')
    <x-slot:title>User Account Settings</x-slot:title>

    <!-- تم إضافة x-data لإدارة التنقل بين التبويبات ديناميكياً لتكون الصفحة شغالة 100% -->
    <main x-data="{ currentTab: 'profile' }"
        class="max-w-[1700px] mx-auto w-full h-[calc(100vh-4rem)] flex gap-6 p-6 overflow-hidden bg-[#F8FAFC] antialiased font-sans">

        <!-- Inside Core Workspace Container -->
        <div class="flex-grow bg-white border border-slate-200 rounded-2xl flex shadow-sm overflow-hidden h-full w-full">

            <!-- 1. Internal Settings Sidebar Menu -->
            <aside class="w-[280px] border-r border-slate-200 bg-slate-50/50 p-6 flex flex-col gap-1 shrink-0">
                <div class="mb-4 px-3">
                    <h2 class="text-xs font-mono font-bold text-slate-400 uppercase tracking-widest">Account Dashboard</h2>
                </div>

                <!-- Profile Tab -->
                <button type="button" @click="currentTab = 'profile'"
                    :class="currentTab === 'profile' ? 'bg-indigo-600 text-white shadow-sm' :
                        'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-[14px] text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">person</span>
                    <span>Profile Info</span>
                </button>

                <!-- Security Tab -->
                <button type="button" @click="currentTab = 'security'"
                    :class="currentTab === 'security' ? 'bg-indigo-600 text-white shadow-sm' :
                        'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-[14px] text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">security</span>
                    <span>Security & Password</span>
                </button>

                <!-- AI Preferences Tab -->
                <button type="button" @click="currentTab = 'ai'"
                    :class="currentTab === 'ai' ? 'bg-indigo-600 text-white shadow-sm' :
                        'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-[14px] text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">auto_awesome</span>
                    <span>AI Preferences</span>
                </button>

                {{-- <!-- Files Review Tab -->
                <button type="button" @click="currentTab = 'files'"
                    :class="currentTab === 'files' ? 'bg-indigo-600 text-white shadow-sm' :
                        'text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50'"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-[14px] text-left transition-all w-full">
                    <span class="material-symbols-outlined text-lg">folder_open</span>
                    <span>Files & Review</span>
                </button> --}}
            </aside>

            <!-- 2. Settings Core Content Dynamic Area -->
            <!-- فورم رئيسي لإرسال التعديلات لحفظها -->
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data"
                class="flex-grow h-full flex flex-col overflow-hidden">
                @csrf
                @method('PUT')

                <!-- Breadcrumb Top Header -->
                <header
                    class="px-8 py-4 border-b border-slate-200 bg-slate-50/30 flex justify-between items-center shrink-0">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                        <span class="text-slate-900 font-extrabold text-[13px]">Settings</span>
                        <span class="material-symbols-outlined text-sm font-black">chevron_right</span>
                        <span class="text-indigo-600 font-extrabold"
                            x-text="currentTab.charAt(0).toUpperCase() + currentTab.slice(1) + ' Info'">Profile Info</span>
                    </div>
                </header>

                <!-- Scrollable Form Panels Container -->
                <div class="flex-1 p-8 overflow-y-auto scrollbar-thin bg-white">

                    @if (session('success'))
                        <div
                            class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm font-semibold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- ================= TAB 1: PROFILE INFO ================= -->
                    <div x-show="currentTab === 'profile'" class="flex flex-col gap-8 max-w-4xl">
                        <div class="flex flex-col gap-4">
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Personal Profile</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Manage your public account identity, credentials,
                                    and digital avatar representation.</p>
                            </div>
                            <div class="h-[1px] bg-slate-100 w-full"></div>

                            <!-- إدارة صورة الحساب (Avatar) -->
                            <div class="flex items-center gap-6 my-2 bg-slate-50/50 p-4 border border-slate-200 rounded-xl">
                                <div
                                    class="relative w-20 h-20 rounded-full bg-indigo-100 border-2 border-slate-200 flex items-center justify-center overflow-hidden">
                                    @if (auth()->user() && auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                            class="w-full h-full object-cover" id="avatar_preview">
                                    @else
                                        <span class="text-2xl font-black text-indigo-600 uppercase" id="avatar_placeholder">
                                            {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-slate-700 uppercase">Profile Picture</label>
                                    <input type="file" name="avatar" accept="image/*"
                                        class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                    <p class="text-[11px] text-slate-400">PNG, JPG up to 2MB.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Full
                                        Name</label>
                                    <input type="text" name="name"
                                        value="{{ auth()->user()->name ?? 'User Account' }}"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium text-slate-900 shadow-2xs transition-all">
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Email
                                        Address</label>
                                    <input type="email" name="email"
                                        value="{{ auth()->user()->email ?? 'user@workspace.ai' }}"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium text-slate-900 shadow-2xs transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Connected Gateways Section (من كودك الأصلي داخل البروفايل) -->
                        <div class="flex flex-col gap-4 mt-4">
                            <div class="flex justify-between items-end">
                                <div>
                                    <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Connected Core Gateways
                                    </h3>
                                    <p class="text-sm text-slate-500 mt-0.5">Link third-party technical software
                                        environments.</p>
                                </div>
                            </div>
                            <div class="h-[1px] bg-slate-100 w-full"></div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div
                                    class="bg-white border border-slate-200 p-4 rounded-2xl shadow-2xs flex flex-col gap-4">
                                    <div class="flex justify-between items-start">
                                        <div
                                            class="w-9 h-9 bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center font-black rounded-xl">
                                            #</div><span
                                            class="text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 rounded-md">CONNECTED</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900">Slack Cluster</h4>
                                    <button type="button"
                                        class="w-full py-1.5 text-xs font-bold border border-slate-200 text-slate-700 rounded-xl mt-auto">Configure</button>
                                </div>
                                <div
                                    class="bg-white border border-slate-200 p-4 rounded-2xl shadow-2xs flex flex-col gap-4">
                                    <div class="flex justify-between items-start">
                                        <div
                                            class="w-9 h-9 bg-slate-950 text-white flex items-center justify-center font-black rounded-xl">
                                            ▲</div><span
                                            class="text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 px-2 py-0.5 rounded-md">CONNECTED</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900">Vercel Webhooks</h4>
                                    <button type="button"
                                        class="w-full py-1.5 text-xs font-bold border border-slate-200 text-slate-700 rounded-xl mt-auto">Configure</button>
                                </div>
                                <div
                                    class="bg-white border border-slate-200 p-4 rounded-2xl shadow-2xs flex flex-col gap-4">
                                    <div class="flex justify-between items-start">
                                        <div
                                            class="w-9 h-9 bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center rounded-xl">
                                            <span class="material-symbols-outlined text-lg">database</span></div><span
                                            class="text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 px-2 py-0.5 rounded-md">DISCONNECTED</span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900">Supabase Engine</h4>
                                    <button type="button"
                                        class="w-full py-1.5 text-xs font-bold bg-indigo-600 text-white rounded-xl mt-auto">Connect
                                        API</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 2: SECURITY & PASSWORD ================= -->
                    <div x-show="currentTab === 'security'" class="flex flex-col gap-8 max-w-4xl">
                        <!-- تغيير كلمة السر -->
                        <div class="flex flex-col gap-4">
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Security & Encryption</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Update your password regularly to ensure your
                                    cloud node remains fully locked.</p>
                            </div>
                            <div class="h-[1px] bg-slate-100 w-full"></div>

                            <div class="flex flex-col gap-4 mt-2">
                                <div class="flex flex-col gap-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Current
                                        Password</label>
                                    <input type="password" name="current_password" placeholder="••••••••"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium text-slate-900 shadow-2xs transition-all">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="flex flex-col gap-2">
                                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">New
                                            Password</label>
                                        <input type="password" name="new_password" placeholder="••••••••"
                                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium text-slate-900 shadow-2xs transition-all">
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Confirm New
                                            Password</label>
                                        <input type="password" name="new_password_confirmation" placeholder="••••••••"
                                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-sm font-medium text-slate-900 shadow-2xs transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- حذف الحساب نهائياً -->
                        <div class="flex flex-col gap-4 mt-4 border border-rose-100 bg-rose-50/20 rounded-2xl p-6">
                            <div>
                                <h3 class="text-lg font-extrabold text-rose-600 tracking-tight">Danger Zone</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Permanently delete your account workspace,
                                    vectors, and analytical cache logs. This action cannot be reversed.</p>
                            </div>
                            <div class="h-[1px] bg-rose-100 w-full"></div>

                            <!-- زر حذف شغال عن طريق فورم منفصل لمنع تداخل الحقول -->
                            <div class="flex justify-between items-center mt-2">
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Confirm Account
                                    Deletion</p>
                                <button type="button" onclick="confirmDeleteAccount()"
                                    class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md transition-all active:scale-95">
                                    Delete Account Permanent
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 3: AI PREFERENCES ================= -->
                    <div x-show="currentTab === 'ai'" class="flex flex-col gap-8 max-w-4xl">
                        <div class="flex flex-col gap-4">
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">AI Workspace Preferences
                                </h3>
                                <p class="text-sm text-slate-500 mt-0.5">Configure how the core LLM engines analyze
                                    document streams and generate extraction pipelines.</p>
                            </div>
                            <div class="h-[1px] bg-slate-100 w-full"></div>

                            <div
                                class="border border-slate-200 rounded-2xl p-6 bg-slate-50/40 flex flex-col gap-6 shadow-2xs">
                                <div class="flex flex-col gap-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-bold text-slate-800">Automated Analysis Severity</span>
                                        <span
                                            class="text-xs font-mono font-extrabold px-2.5 py-0.5 rounded-md bg-indigo-50 border border-indigo-100 text-indigo-700">Balanced
                                            (75%)</span>
                                    </div>
                                    <input type="range" name="ai_severity" min="1" max="100"
                                        value="75"
                                        class="w-full accent-indigo-600 h-1.5 bg-slate-200 rounded-lg cursor-pointer">
                                </div>
                                <div class="h-[1px] bg-slate-200/60 w-full"></div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <label
                                        class="flex items-start gap-3 p-4 bg-white border border-slate-200 rounded-xl shadow-2xs cursor-pointer select-none">
                                        <input type="checkbox" name="auto_extract" value="1" checked
                                            class="mt-1 w-4 h-4 text-indigo-600 rounded accent-indigo-600">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Auto-Extraction Pipelines</p>
                                        </div>
                                    </label>
                                    <label
                                        class="flex items-start gap-3 p-4 bg-white border border-slate-200 rounded-xl shadow-2xs cursor-pointer select-none">
                                        <input type="checkbox" name="prompt_guarding" value="1" checked
                                            class="mt-1 w-4 h-4 text-indigo-600 rounded accent-indigo-600">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">Contextual Prompt Guarding</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================= TAB 4: FILES REVIEW ================= -->
                    <div x-show="currentTab === 'files'" class="flex flex-col gap-8 max-w-4xl">
                        <div class="flex flex-col gap-4">
                            <div>
                                <h3 class="text-lg font-extrabold text-slate-900 tracking-tight">Recent Files & Storage
                                    Audit</h3>
                                <p class="text-sm text-slate-500 mt-0.5">Review and audit vector stored training datasets
                                    and pipeline schema configurations.</p>
                            </div>
                            <div class="h-[1px] bg-slate-100 w-full"></div>

                            {{-- <!-- جدول الملفات المرفوعة لمراجعتها -->
                            <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-2xs mt-2">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr
                                            class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                            <th class="p-4">File Identity</th>
                                            <th class="p-4">Status</th>
                                            <th class="p-4">Uploaded At</th>
                                            <th class="p-4 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-xs text-slate-700 divide-y divide-slate-100">
                                        @forelse($files as $file)
                                            <tr>
                                                <td class="p-4 flex items-center gap-2 font-bold text-slate-900">
                                                    <span
                                                        class="material-symbols-outlined text-indigo-500 text-sm">description</span>
                                                    {{ $file->name }}
                                                </td>

                                                <td class="p-4">
                                                    @if ($file->status === 'parsed' || $file->status === 'success')
                                                        <span
                                                            class="bg-emerald-50 text-emerald-700 font-bold px-2 py-0.5 border border-emerald-100 rounded-md text-[10px] uppercase">
                                                            {{ $file->status }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="bg-indigo-50 text-indigo-700 font-bold px-2 py-0.5 border border-indigo-100 rounded-md text-[10px] uppercase">
                                                            {{ $file->status ?? 'ACTIVE' }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td class="p-4 font-medium text-slate-400">
                                                    {{ $file->created_at->format('M d, Y') }}
                                                </td>

                                                <td class="p-4 text-right">
                                                    <a class="text-indigo-600 hover:underline font-bold">
                                                        Review Vectors
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"
                                                    class="p-8 text-center text-sm font-medium text-slate-400">
                                                    <span
                                                        class="material-symbols-outlined text-2xl block mb-1">folder_open</span>
                                                    No documents uploaded yet inside this workspace.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div> --}}
                        </div>
                    </div>

                </div>

                <!-- Footer Terminal Console Action Row -->
                <footer
                    class="p-4 border-t border-slate-200 bg-slate-50/80 z-10 flex gap-3 justify-end items-center shrink-0">
                    <button type="button" @click="window.location.reload()"
                        class="px-4 py-2 border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-xl text-xs font-bold shadow-2xs transition-all">
                        Discard Changes
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md active:scale-95 transition-all">
                        Save Preferences
                    </button>
                </footer>

            </form>

            <!-- نموذج مخفي لحذف الحساب بأمان لحماية هندسة النظام -->
            <form id="delete-account-form" action="{{ route('settings.destroy') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </main>

    <!-- سكربت جافاسكريبت للتحذير قبل حذف الحساب والتأكد من تفعيل AlpineJS -->
    <script>
        function confirmDeleteAccount() {
            if (confirm(
                    "🚨 هل أنت متأكد تماماً من رغبتك في حذف حسابك؟ هذا الإجراء سيقوم بمسح كافة ملفاتك وقواعد البيانات الخاصة بك نهائياً ولا يمكن الرجوع عنه!"
                    )) {
                document.getElementById('delete-account-form').submit();
            }
        }
        // إضافة دعم لـ Alpine.js في حال لم يكن مضمناً في مشروعك لتعمل الأزرار فوراً
        if (typeof Alpine === 'undefined') {
            document.write('<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer><\/script>');
        }
    </script>
@endsection
