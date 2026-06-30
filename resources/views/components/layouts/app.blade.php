<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'LexiGuard AI' }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#004ac6",
                        "inverse-on-surface": "#f0f0fb",
                        "on-primary-container": "#eeefff",
                        "on-surface": "#191b23",
                        "surface-dim": "#d9d9e5",
                        "on-error": "#ffffff",
                        "on-primary": "#ffffff",
                        "secondary-fixed": "#d3e4fe",
                        "outline": "#737686",
                        "on-tertiary-container": "#ffede6",
                        "on-secondary-fixed-variant": "#38485d",
                        "surface-variant": "#e1e2ed",
                        "on-background": "#191b23",
                        "on-surface-variant": "#434655",
                        "secondary": "#505f76",
                        "tertiary-fixed": "#ffdbcd",
                        "background": "#faf8ff",
                        "on-secondary": "#ffffff",
                        "primary-fixed": "#dbe1ff",
                        "surface-container": "#ededf9",
                        "error": "#ba1a1a",
                        "inverse-surface": "#2e3039",
                        "tertiary-fixed-dim": "#ffb596",
                        "on-primary-fixed-variant": "#003ea8",
                        "on-secondary-fixed": "#0b1c30",
                        "surface-container-highest": "#e1e2ed",
                        "on-primary-fixed": "#00174b",
                        "primary-container": "#2563eb",
                        "surface-container-low": "#f3f3fe",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#b7c8e1",
                        "inverse-primary": "#b4c5ff",
                        "tertiary": "#943700",
                        "on-tertiary-fixed-variant": "#7d2d00",
                        "surface-container-high": "#e7e7f3",
                        "surface-container-lowest": "#ffffff",
                        "secondary-container": "#d0e1fb",
                        "surface-tint": "#0053db",
                        "on-secondary-container": "#54647a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#bc4800",
                        "primary-fixed-dim": "#b4c5ff",
                        "outline-variant": "#c3c6d7",
                        "surface": "#faf8ff",
                        "on-tertiary-fixed": "#360f00",
                        "surface-bright": "#faf8ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xxl": "64px",
                        "lg": "24px",
                        "sm": "8px",
                        "xl": "40px",
                        "gutter": "24px",
                        "xs": "4px",
                        "base": "4px",
                        "md": "16px",
                        "container-max": "1280px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "label-md": ["JetBrains Mono"],
                        "body-sm": ["Inter"],
                        "headline-xl": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-sm": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-md": ["13px", { "lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "500" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "headline-xl": ["40px", { "lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "headline-lg-mobile": ["26px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-lg": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "headline-sm": ["20px", { "lineHeight": "28px", "fontWeight": "600" }]
                    }
                },
            },
        }
    </script>
    
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        body { background-color: #faf8ff; -webkit-font-smoothing: antialiased; }
        .bento-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .bento-card:hover { transform: translateY(-4px); box-shadow: 0px 4px 12px rgba(30, 41, 59, 0.05); }
        .upload-gradient { background: linear-gradient(135deg, #004ac6 0%, #2563eb 100%); }
    </style>
</head>

<body class="font-body-md text-on-surface">
@unless(isset($hideNav) && $hideNav)
    <header class="bg-surface-container-lowest border-b border-outline-variant fixed top-0 w-full z-50">
        <div class="flex justify-between items-center h-16 px-gutter max-w-container-max mx-auto w-full">
            <div class="font-headline-sm text-headline-sm font-bold text-primary">
                LexiGuard AI
            </div>
            <nav class="hidden md:flex items-center space-x-lg font-body-md text-body-md">
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Documents</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">History</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Templates</a>
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
@endunless
    <main class="pt-[120px] pb-xxl min-h-screen flex flex-col items-center justify-center px-gutter w-full max-w-container-max mx-auto">
        {{ $slot }}
    </main>

    <footer class="bg-surface-container-lowest border-t border-outline-variant mt-xxl">
        <div class="flex flex-col md:flex-row justify-between items-center py-md px-gutter max-w-container-max mx-auto w-full">
            <div class="font-body-sm text-body-sm text-on-surface-variant text-center md:text-left mb-md md:mb-0">
                © 2026 LexiGuard AI. Legal-grade security guaranteed.
            </div>
            <nav class="flex gap-lg">
                <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Security</a>
                <a class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors" href="#">Support</a>
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