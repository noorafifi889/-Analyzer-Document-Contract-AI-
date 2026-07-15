<header class="sticky top-0 z-30 w-full bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center h-16 px-4 lg:pl-[296px] lg:pr-margin-page gap-2">

    <div class="flex items-center gap-2 sm:gap-4 flex-1 min-w-0">

        <button
            type="button"
            @click="$store.sidebar.open = true"
            class="lg:hidden shrink-0 w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition-colors"
            aria-label="Open menu">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <div class="relative w-full max-w-md min-w-0" x-data="headerSearch()" @click.outside="open = false">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg" data-icon="search">search</span>

            <input
                class="w-full bg-surface-container-low border-none rounded-full pl-10 pr-10 py-2 text-body-md focus:ring-1 focus:ring-primary truncate"
                placeholder="Search..."
                type="text"
                x-model="query"
                @input.debounce.350ms="search()"
                @focus="if (results) open = true"
                @keydown.enter.prevent
            />

            <div x-show="loading" class="absolute right-3 top-1/2 -translate-y-1/2" x-cloak>
                <span class="material-symbols-outlined animate-spin text-on-surface-variant text-lg">progress_activity</span>
            </div>

            <div
                x-show="open"
                x-transition
                x-cloak
                class="absolute mt-2 w-full bg-surface-container rounded-2xl shadow-lg border border-outline-variant overflow-hidden z-50"
                style="display: none;"
            >
                <template x-if="results && results.documents.length === 0">
                    <p class="px-4 py-3 text-body-sm text-on-surface-variant">No result found.</p>
                </template>

                <template x-if="results && results.documents.length > 0">
                    <div>
                        <p class="px-4 pt-3 pb-1 text-label-sm font-bold text-on-surface-variant">Documents</p>
                        <template x-for="doc in results.documents" :key="doc.id">
                            <a :href="`/intelligence/${doc.id}`" class="flex items-center gap-2 px-4 py-2 hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-lg text-on-surface-variant">description</span>
                                <span class="text-body-md truncate" x-text="doc.title"></span>
                            </a>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-1 sm:gap-3 shrink-0">
        
        <div class="relative" x-data="{ 
            open: false, 
            notifications: [],
            unreadCount: 0,
            
            // دالة ذكية لتحويل مسميات الأيقونات لتتوافق مع Google Material Symbols
            getIconName(laravelIcon) {
                const iconMap = {
                    'user-plus': 'person_add',
                    'shield-alert': 'security',
                    'file-check': 'fact_check',
                    'notifications': 'notifications'
                };
                return iconMap[laravelIcon] || 'notifications';
            },

            async init() {
                try {
                    let response = await fetch('/api/notifications');
                    let data = await response.json();
                    this.notifications = data.notifications;
                    this.unreadCount = data.unread_count;
                } catch (e) {
                    console.error('Failed to fetch notifications:', e);
                }

                if (typeof Echo !== 'undefined') {
                    Echo.private('App.Models.User.' + '{{ auth()->id() }}')
                        .notification((notification) => {
                            this.notifications.unshift({
                                id: notification.id,
                                data: {
                                    title: notification.title,
                                    message: notification.message,
                                    icon: notification.icon || 'notifications'
                                },
                                read_at: null,
                                created_at: 'Just now'
                            });
                            this.unreadCount++;
                        });
                }
            },
            async markAllAsRead() {
                this.unreadCount = 0;
                await fetch('/api/notifications/read', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            }
        }" @click.outside="open = false">

            <button 
                type="button" 
                @click="open = !open; if(open) markAllAsRead();"
                class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition-colors relative">
                <span class="material-symbols-outlined text-[24px]" data-icon="notifications">notifications</span>
                
                <span 
                    x-show="unreadCount > 0" 
                    x-transition
                    class="absolute -top-1 -right-1 bg-error text-on-error text-[11px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-surface shadow-sm"
                    x-text="unreadCount"
                    x-cloak>
                </span>
            </button>

            <div 
                x-show="open" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 y-[-10px]"
                x-transition:enter-end="opacity-100 scale-100 y-0"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-3 w-[450px] max-w-[calc(100vw-32px)] bg-surface-container rounded-3xl shadow-2xl border border-outline-variant overflow-hidden z-50 origin-top-right"
                style="display: none;"
                x-cloak>
                
                <div class="px-5 py-4 border-b border-outline-variant/60 flex justify-between items-center bg-surface-container-high">
                    <span class="text-title-medium font-extrabold text-on-surface tracking-wide">Notifications</span>
                    <span x-show="unreadCount > 0" class="bg-error/15 text-error text-xs px-3 py-1 rounded-full font-bold shadow-sm" x-text="unreadCount + ' new'"></span>
                </div>

                <div class="max-h-[420px] overflow-y-auto divide-y divide-outline-variant/40">
                    <template x-if="notifications.length === 0">
                        <div class="px-6 py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-5xl mb-3 opacity-40 text-primary">notifications_off</span>
                            <p class="text-body-md font-medium">You are all caught up!</p>
                            <p class="text-label-md text-on-surface-variant/60 mt-1">No new notifications at this time.</p>
                        </div>
                    </template>

                    <template x-for="item in notifications" :key="item.id">
                        <div class="p-5 hover:bg-surface-container-high/60 transition-all flex gap-4 items-start" :class="{'bg-primary/5': !item.read_at}">
                            
                            <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 shadow-sm">
                                <span class="material-symbols-outlined text-[24px]" x-text="getIconName(item.data.icon)"></span>
                            </div>
                            
                            <div class="flex-1 min-w-0 flex flex-col gap-1">
                                <div class="flex justify-between items-baseline gap-2">
                                    <p class="text-body-md font-bold text-on-surface" x-text="item.data.title"></p>
                                    <span class="text-label-sm text-on-surface-variant/60 shrink-0 font-medium" x-text="item.created_at || 'Just now'"></span>
                                </div>
                                
                                <p class="text-body-sm text-on-surface-variant leading-relaxed break-words" x-text="item.data.message"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <a href="{{ route('help.index') }}" class="hidden sm:flex items-center gap-2 p-2 text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined" data-icon="help">help</span>
        </a>
        
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="header-upload-form" class="inline-block">
            @csrf
            <input type="hidden" name="redirect_to" value="intelligence">
            <label class="bg-primary text-on-primary w-10 h-10 sm:w-auto sm:px-6 sm:py-2.5 rounded-full font-label-md text-label-md font-bold flex items-center justify-center sm:justify-start gap-2 shadow-sm hover:opacity-90 active:scale-95 transition-all cursor-pointer">
                <span class="material-symbols-outlined" data-icon="upload">upload</span>
                <span class="hidden sm:inline">Upload Contract</span>
                <input type="file" name="document" class="hidden" onchange="submitHeaderUploadForm(this)">
            </label>
        </form>
    </div>
</header>