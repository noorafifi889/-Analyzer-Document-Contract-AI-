<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'LexiGuard AI' }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #faf8ff; -webkit-font-smoothing: antialiased; }
        .bento-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .bento-card:hover { transform: translateY(-4px); box-shadow: 0px 4px 12px rgba(30, 41, 59, 0.05); }
        .upload-gradient { background: linear-gradient(135deg, #004ac6 0%, #2563eb 100%); }
    </style>
</head>

<body class="font-body-md text-on-surface">

    <header class="bg-surface-container-lowest dark:bg-surface border-b border-outline-variant dark:border-outline fixed top-0 w-full z-50">
        <div class="flex justify-between items-center h-16 px-gutter max-w-container-max mx-auto w-full">
            <div class="font-headline-sm text-headline-sm font-bold text-primary dark:text-primary-fixed">
                LexiGuard AI
            </div>
            <nav class="hidden md:flex items-center space-x-lg font-body-md text-body-md">
                <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary transition-colors" href="#">Documents</a>
                <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary transition-colors" href="#">History</a>
                <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary transition-colors" href="#">Templates</a>
            </nav>
            <div class="flex items-center gap-md">
                <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-all">notifications</button>
                <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-all">settings</button>
                <div class="w-8 h-8 rounded-full bg-surface-container-high overflow-hidden border border-outline-variant">
                    <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD-pvXJbiFL7vBZskcVzhsvxLG5Bs3xtYHS6Q6nmkOW5nRUMlqK-124QdFdBywVy46hZ-hyLFWfr9xe4hUw5btFEjDjNWip-Tntwljv61mTpsAOutdqlaYp3b90R0UL7yyiEq-3byXK0wXozL1SLhHGx5v_FfPHI2cA1oc4VXjjJ9oHYaDGQB0RpKIjHM4qOo-k-j5yexl_ab5Fk_1EEBj9BaPbz_TfZ_NKWwRDbP_1IGqWXW2RODgsFMYIMc1Vyr7ueT1raRsWfnA" />
                </div>
            </div>
        </div>
    </header>

    <main class="pt-xxl min-h-screen flex flex-col items-center justify-center px-gutter">
        {{ $slot }}
    </main>

    <footer class="bg-surface-container-lowest dark:bg-surface border-t border-outline-variant dark:border-outline mt-xxl">
        <div class="flex flex-col md:flex-row justify-between items-center py-md px-gutter max-w-container-max mx-auto w-full">
            <div class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant text-center md:text-left mb-md md:mb-0">
                © 2026 LexiGuard AI. Legal-grade security guaranteed.
            </div>
            <nav class="flex gap-lg">
                <a class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="#">Privacy Policy</a>
                <a class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="#">Terms of Service</a>
                <a class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="#">Security</a>
                <a class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" href="#">Support</a>
            </nav>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const uploadBtn = document.querySelector('.upload-gradient');
            if(uploadBtn) {
                uploadBtn.addEventListener('mouseenter', () => {
                    const icon = uploadBtn.querySelector('.material-symbols-outlined');
                    if(icon) icon.style.transform = 'translateY(-2px)';
                });
                uploadBtn.addEventListener('mouseleave', () => {
                    const icon = uploadBtn.querySelector('.material-symbols-outlined');
                    if(icon) icon.style.transform = 'translateY(0px)';
                });
            }
        });
    </script>
</body>
</html>