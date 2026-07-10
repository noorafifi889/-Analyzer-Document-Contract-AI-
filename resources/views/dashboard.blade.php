{{-- <x-layouts.app>
    <x-slot:title>
        LexiGuard AI - الصفحة الرئيسية
    </x-slot:title>

    <div class="max-w-2xl w-full text-center space-y-xl animate-in fade-in duration-700 slide-in-from-bottom-4">
        <div class="flex justify-center mb-xl">
            <div class="w-24 h-24 bg-surface-container-lowest rounded-xl border border-outline-variant flex items-center justify-center text-primary shadow-sm">
                <span class="material-symbols-outlined text-[48px]" style="font-variation-settings: 'wght' 300;">description</span>
            </div>
        </div>
        
        <div class="space-y-md">
            <h1 class="font-headline-xl text-headline-xl text-on-surface tracking-tight">LexiGuard AI</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg mx-auto">
                Smart analysis for HR, Legal, and Business. Uncover risks and insights in seconds with our legal-grade security engine.
            </p>
        </div>

        <div class="w-full max-w-md mx-auto">
            @if(session('success'))
                <div class="mb-md p-md bg-green-50 text-green-700 rounded-lg border border-green-200 text-sm flex items-center gap-sm justify-center">
                    <span class="material-symbols-outlined">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-md p-md bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm text-left">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="dashboard-upload-form" class="pt-lg flex flex-col items-center gap-md">
            @csrf

            <label for="document" id="upload-label"
                class="upload-gradient text-on-primary px-xl py-md rounded-lg font-headline-sm flex items-center gap-sm hover:opacity-90 active:scale-95 transition-all shadow-md group cursor-pointer">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">
                    upload_file
                </span>
                <span>Upload Document</span>
            </label>

            <input
                type="file"
                id="document"
                name="document"
                accept=".pdf,.docx,.txt"
                class="hidden">

            <p class="font-body-sm text-body-sm text-outline">
                Supported formats: PDF, DOCX, TXT. Max size 25MB.
            </p>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-md mt-xxl text-left">
            <div class="bento-card p-md bg-surface-container-lowest border border-outline-variant rounded-xl">
                <span class="material-symbols-outlined text-primary mb-sm">verified_user</span>
                <h3 class="font-headline-sm text-[16px] text-on-surface mb-xs">Risk Assessment</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Automated identification of high-risk clauses and liabilities.</p>
            </div>

            <div class="bento-card p-md bg-surface-container-lowest border border-outline-variant rounded-xl">
                <span class="material-symbols-outlined text-primary mb-sm">bolt</span>
                <h3 class="font-headline-sm text-[16px] text-on-surface mb-xs">Instant Summary</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Get the core terms and obligations in plain English.</p>
            </div>

            <div class="bento-card p-md bg-surface-container-lowest border border-outline-variant rounded-xl">
                <span class="material-symbols-outlined text-primary mb-sm">translate</span>
                <h3 class="font-headline-sm text-[16px] text-on-surface mb-xs">Smart Translation</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Translate legal terminology across 20+ jurisdictions.</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('document').addEventListener('change', function() {
            const form = document.getElementById('dashboard-upload-form');
            const label = document.getElementById('upload-label');
            
            if (this.files && this.files.length > 0) {
                // تفعيل تأثير التحميل بصرياً
                label.style.opacity = '0.7';
                label.style.pointerEvents = 'none';
                label.innerHTML = `<span class="material-symbols-outlined animate-spin">progress_activity</span> <span>Uploading...</span>`;
                
                // إرسال الفورم فوراً إلى السيرفر
                form.submit();
            }
        });
    </script>
</x-layouts.app> --}}

@extends('layouts.app')

@section('title', 'Dashboard - ContractGuard AI')

@section('content')
    <section class="flex justify-between items-end">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Welcome back,      {{ auth()->user()->name }} </h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-1">Here's what's happening with your legal workspace today.</p>
        </div>
        <div class="flex items-center gap-3 text-on-surface-variant bg-surface-container-low px-4 py-2 rounded-lg border border-outline-variant">
            <span class="material-symbols-outlined" data-icon="calendar_today">calendar_today</span>
            <span class="font-label-md text-label-md font-bold">Oct 24, 2023 - Oct 31, 2023</span>-
            <span class="material-symbols-outlined" data-icon="expand_more">expand_more</span>
        </div>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-primary-fixed rounded-lg text-primary">
                    <span class="material-symbols-outlined" data-icon="description">description</span>
                </div>
                <span class="text-primary font-bold text-label-sm">+4%</span>
            </div>
            <p class="font-label-md text-label-md text-on-surface-variant">Total Contracts</p>
            <p class="font-headline-lg text-headline-lg font-extrabold mt-1">1,248</p>
        </div>
        
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-error-container rounded-lg text-error">
                    <span class="material-symbols-outlined" data-icon="warning" style="font-variation-settings: 'FILL' 1;">warning</span>
                </div>
                <span class="text-error font-bold text-label-sm">-2 active</span>
            </div>
            <p class="font-label-md text-label-md text-on-surface-variant">Active Risks</p>
            <p class="font-headline-lg text-headline-lg font-extrabold mt-1">12</p>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-tertiary-fixed rounded-lg text-tertiary">
                    <span class="material-symbols-outlined" data-icon="pending_actions">pending_actions</span>
                </div>
                <span class="text-tertiary font-bold text-label-sm">3 due soon</span>
            </div>
            <p class="font-label-md text-label-md text-on-surface-variant">Pending Renewals</p>
            <p class="font-headline-lg text-headline-lg font-extrabold mt-1">5</p>
        </div>

        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-secondary-fixed rounded-lg text-secondary">
                    <span class="material-symbols-outlined" data-icon="monetization_on">monetization_on</span>
                </div>
                <span class="text-secondary font-bold text-label-sm">+$0.4M</span>
            </div>
            <p class="font-label-md text-label-md text-on-surface-variant">Total Value</p>
            <p class="font-headline-lg text-headline-lg font-extrabold mt-1">$4.2M</p>
        </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
        </section>
@endsection