@php
    $brand = config('portfolio.brand', []);
    $appName = $brand['name'] ?? config('app.name', 'ERICKsky');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        @include('partials.head')
        <script>
            (function () {
                var light = localStorage.getItem('portfolio-theme') === 'light';
                try {
                    localStorage.setItem('flux.appearance', light ? 'light' : 'dark');
                } catch (e) {}
                if (light) {
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
    </head>
    <body class="admin-app-shell">
        {{-- collapsible=true: desktop rail (icons) + mobile drawer; collapsible=mobile hid the rail toggle on lg+ --}}
        <flux:sidebar sticky :collapsible="true" class="admin-sidebar border-e border-zinc-200/90 bg-zinc-50/95 backdrop-blur-xl dark:border-zinc-800/90 dark:bg-zinc-950/95">
            <flux:sidebar.header>
                <a href="{{ route('dashboard') }}" class="flex min-w-0 flex-1 items-center gap-3" wire:navigate>
                    <span class="flex size-10 shrink-0 overflow-hidden rounded-xl bg-zinc-900 ring-2 ring-terra/25 shadow-md">
                        <img src="{{ asset('logo.jpeg') }}" alt="" class="size-full object-cover" width="40" height="40" />
                    </span>
                    <div class="min-w-0 flex-1 in-data-flux-sidebar-collapsed-desktop:hidden">
                        <p class="truncate font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $appName }}</p>
                        <p class="truncate font-mono text-[10px] text-terra">{{ __('Admin') }}</p>
                    </div>
                </a>
                <flux:sidebar.collapse
                    class="shrink-0 in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-me-1"
                    tooltip="{{ __('Minimize or expand sidebar') }}"
                />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                {{-- Custom section labels (not flux:sidebar.group with heading) so links stay visible when the rail is collapsed to icons only. Fluent Color icons: https://icon-sets.iconify.design/fluent-color/ --}}
                <div class="flex flex-col gap-0.5">
                    <p class="mt-0 px-3 py-2 text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 in-data-flux-sidebar-collapsed-desktop:hidden">
                        {{ __('Platform') }}
                    </p>
                    <x-admin.sidebar-link :href="route('dashboard')" icon="board-24" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-admin.sidebar-link>
                </div>

                <div class="mt-3 flex flex-col gap-0.5">
                    <p class="px-3 py-2 text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 in-data-flux-sidebar-collapsed-desktop:hidden">
                        {{ __('Content') }}
                    </p>
                    <x-admin.sidebar-link :href="route('admin.projects')" icon="apps-24" :active="request()->routeIs('admin.projects')">
                        {{ __('Projects') }}
                    </x-admin.sidebar-link>
                    <x-admin.sidebar-link :href="route('admin.services')" icon="briefcase-24" :active="request()->routeIs('admin.services')">
                        {{ __('Services') }}
                    </x-admin.sidebar-link>
                    <x-admin.sidebar-link :href="route('admin.site-profile')" icon="document-text-24" :active="request()->routeIs('admin.site-profile')">
                        {{ __('Site profile') }}
                    </x-admin.sidebar-link>
                    <x-admin.sidebar-link :href="route('admin.inquiries')" icon="mail-alert-24" :active="request()->routeIs('admin.inquiries')">
                        {{ __('Inquiries') }}
                    </x-admin.sidebar-link>
                    <x-admin.sidebar-link :href="route('admin.media')" icon="image-24" :active="request()->routeIs('admin.media')">
                        {{ __('Media') }}
                    </x-admin.sidebar-link>
                </div>

                <div class="mt-3 flex flex-col gap-0.5">
                    <p class="px-3 py-2 text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 in-data-flux-sidebar-collapsed-desktop:hidden">
                        {{ __('Portfolio site') }}
                    </p>
                    <x-admin.sidebar-link :href="route('home')" icon="globe-24" :external="true">
                        {{ __('View public site') }}
                    </x-admin.sidebar-link>
                </div>

                <div class="mt-3 flex flex-col gap-0.5">
                    <p class="px-3 py-2 text-[10px] font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 in-data-flux-sidebar-collapsed-desktop:hidden">
                        {{ __('Account') }}
                    </p>
                    <x-admin.sidebar-link :href="route('profile.edit')" icon="person-24" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-admin.sidebar-link>
                    <x-admin.sidebar-link :href="route('appearance.edit')" icon="paint-brush-24" :active="request()->routeIs('appearance.edit')">
                        {{ __('Appearance') }}
                    </x-admin.sidebar-link>
                    <x-admin.sidebar-link :href="route('security.edit')" icon="lock-closed-24" :active="request()->routeIs('security.edit')">
                        {{ __('Security') }}
                    </x-admin.sidebar-link>
                </div>
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <flux:header class="admin-header border-b border-zinc-200/90 bg-zinc-50/90 backdrop-blur-xl dark:border-zinc-800/90 dark:bg-zinc-950/90 lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
        <script>
            (function () {
                var root = document.documentElement;
                var light = localStorage.getItem('portfolio-theme') === 'light';
                if (light) {
                    root.classList.remove('dark');
                    if (window.Flux && typeof window.Flux.applyAppearance === 'function') {
                        window.Flux.applyAppearance('light');
                    }
                } else {
                    root.classList.add('dark');
                    if (window.Flux && typeof window.Flux.applyAppearance === 'function') {
                        window.Flux.applyAppearance('dark');
                    }
                }
            })();
        </script>
    </body>
</html>
