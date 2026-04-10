@php
    $portfolioData = $portfolio ?? config('portfolio');
    $brand = $portfolioData['brand'];
    $navigation = [
        ['label' => 'Home', 'route' => 'home', 'icon' => 'home-24'],
        ['label' => 'Projects', 'route' => 'projects', 'icon' => 'apps-24'],
        ['label' => 'Services', 'route' => 'services', 'icon' => 'briefcase-24'],
        ['label' => 'About', 'route' => 'about', 'icon' => 'person-24'],
        ['label' => 'Contact', 'route' => 'contact', 'icon' => 'mail-24'],
    ];
    $pageTitle = trim($__env->yieldContent('title')) ?: $brand['name'];
    $icon = fn (string $name) => "https://api.iconify.design/fluent-color:{$name}.svg";
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        @include('partials.head-portfolio', ['title' => $pageTitle, 'portfolio' => $portfolioData])
        @yield('head_extra')

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
    <body class="portfolio-shell min-h-screen text-zinc-900 dark:text-zinc-50">
        <div class="portfolio-grid pointer-events-none fixed inset-0 -z-10 opacity-70"></div>

        <header class="sticky top-0 z-40 border-b border-zinc-200/80 bg-zinc-50/90 backdrop-blur-xl dark:border-zinc-800/80 dark:bg-zinc-950/90">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="group flex min-w-0 flex-1 items-center gap-2.5 sm:gap-3 md:flex-initial">
                    <span class="relative flex size-10 shrink-0 overflow-hidden rounded-2xl bg-zinc-900 ring-2 ring-zinc-200/80 shadow-md ring-offset-2 ring-offset-zinc-50 sm:size-11 dark:ring-zinc-700 dark:ring-offset-zinc-950">
                        <img
                            src="{{ asset('logo.jpeg') }}"
                            alt=""
                            class="size-full object-cover"
                            width="44"
                            height="44"
                        />
                    </span>

                    <div class="hidden min-w-0 sm:block">
                        <p class="truncate text-sm font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">{{ $brand['name'] }}</p>
                        <p class="font-mono text-[11px] text-terra">{{ $brand['nickname'] ?? $brand['name'] }}</p>
                        <p class="hidden text-xs text-zinc-500 lg:block dark:text-zinc-400">{{ $brand['role'] }}</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-1 md:flex" aria-label="Primary">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            class="portfolio-nav-item {{ request()->routeIs($item['route']) ? 'portfolio-nav-item-active' : '' }}"
                            @if (request()->routeIs($item['route']))
                                aria-current="page"
                            @endif
                        >
                            <img src="{{ $icon($item['icon']) }}" alt="" class="size-4 shrink-0" loading="lazy" width="16" height="16">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="flex shrink-0 items-center gap-1.5 sm:gap-3">
                    <button
                        type="button"
                        data-theme-toggle
                        class="portfolio-pill cursor-pointer px-3 py-2 text-xs transition hover:border-terra/35 hover:text-terra sm:px-4 sm:text-sm"
                    >
                        <span data-theme-label>Dark</span>
                    </button>

                    @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex max-w-[6.5rem] truncate rounded-full bg-terra px-3 py-2 text-[11px] font-semibold leading-tight text-white transition hover:bg-blue-600 sm:max-w-none sm:px-5 sm:py-2.5 sm:text-sm"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center rounded-full border border-zinc-300 px-3 py-2 text-xs font-semibold text-zinc-700 transition hover:border-terra/35 hover:text-terra dark:border-zinc-700 dark:text-zinc-100 sm:px-5 sm:py-2.5 sm:text-sm"
                            >
                                Login
                            </a>
                        @endauth
                    @endif

                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-xl border border-zinc-200 bg-white p-2.5 text-zinc-800 shadow-sm transition hover:border-terra/40 hover:text-terra md:hidden dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100"
                        data-mobile-menu-open
                        aria-expanded="false"
                        aria-controls="portfolio-mobile-menu"
                        aria-label="Open menu"
                    >
                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <div
            id="portfolio-mobile-menu"
            class="fixed inset-0 z-[100] md:hidden"
            data-mobile-menu
            role="dialog"
            aria-modal="true"
            aria-labelledby="portfolio-mobile-menu-title"
            hidden
        >
            <button
                type="button"
                class="absolute inset-0 bg-zinc-950/70 backdrop-blur-sm"
                data-mobile-menu-close
                tabindex="-1"
                aria-label="Close menu"
            ></button>

            <div class="absolute inset-y-0 right-0 flex w-[min(100%,18rem)] flex-col border-l border-zinc-200 bg-zinc-50 shadow-2xl dark:border-zinc-700 dark:bg-zinc-950">
                <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-4 dark:border-zinc-800">
                    <p id="portfolio-mobile-menu-title" class="font-semibold text-zinc-900 dark:text-white">Menu</p>
                    <button
                        type="button"
                        class="rounded-lg p-2 text-zinc-600 transition hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-800"
                        data-mobile-menu-close
                        aria-label="Close menu"
                    >
                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex flex-1 flex-col gap-1 overflow-y-auto p-3" aria-label="Mobile">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-base font-medium transition {{ request()->routeIs($item['route']) ? 'bg-terra/15 text-terra' : 'text-zinc-800 hover:bg-zinc-200/80 dark:text-zinc-100 dark:hover:bg-zinc-800/80' }}"
                            data-mobile-nav-link
                            @if (request()->routeIs($item['route']))
                                aria-current="page"
                            @endif
                        >
                            <img src="{{ $icon($item['icon']) }}" alt="" class="size-6 shrink-0" loading="lazy" width="24" height="24">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <main>
            @yield('content')
        </main>

        <footer class="border-t border-zinc-200/80 bg-white/60 py-12 dark:border-zinc-800/80 dark:bg-zinc-950/50">
            <div class="mx-auto flex max-w-6xl flex-col gap-8 px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8">
                <div class="flex gap-4">
                    <span class="mt-0.5 hidden size-10 shrink-0 overflow-hidden rounded-xl ring-1 ring-zinc-200 dark:ring-zinc-700 sm:block">
                        <img src="{{ asset('logo.jpeg') }}" alt="" class="size-full object-cover" width="40" height="40" />
                    </span>
                    <div class="space-y-3">
                        <p class="text-sm font-semibold tracking-tight text-zinc-800 dark:text-zinc-100">{{ $brand['name'] }}</p>
                        <p class="font-mono text-xs text-terra">{{ $brand['nickname'] ?? $brand['name'] }}</p>
                        <p class="max-w-2xl text-sm leading-relaxed text-zinc-600 dark:text-zinc-300">{{ $brand['role'] }}</p>
                    </div>
                </div>

                <nav class="flex flex-wrap gap-2 text-sm" aria-label="Footer">
                    @foreach ($navigation as $item)
                        <a
                            href="{{ route($item['route']) }}"
                            class="text-zinc-500 transition hover:text-terra dark:text-zinc-400"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </footer>

        <script>
            const themeToggleButton = document.querySelector('[data-theme-toggle]');

            if (themeToggleButton) {
                const root = document.documentElement;
                const themeLabel = themeToggleButton.querySelector('[data-theme-label]');

                const applyPortfolioTheme = (isDark) => {
                    if (isDark) {
                        root.classList.add('dark');
                        localStorage.setItem('portfolio-theme', 'dark');
                        try {
                            localStorage.setItem('flux.appearance', 'dark');
                        } catch (e) {}
                    } else {
                        root.classList.remove('dark');
                        localStorage.setItem('portfolio-theme', 'light');
                        try {
                            localStorage.setItem('flux.appearance', 'light');
                        } catch (e) {}
                    }
                    if (window.Flux && typeof window.Flux.applyAppearance === 'function') {
                        window.Flux.applyAppearance(isDark ? 'dark' : 'light');
                    }
                };

                const syncThemeLabel = () => {
                    themeLabel.textContent = root.classList.contains('dark') ? 'Light' : 'Dark';
                };

                syncThemeLabel();

                themeToggleButton.addEventListener('click', () => {
                    applyPortfolioTheme(!root.classList.contains('dark'));
                    syncThemeLabel();
                });
            }
        </script>

        <script>
            (function () {
                const menu = document.querySelector('[data-mobile-menu]');
                const openBtn = document.querySelector('[data-mobile-menu-open]');
                const closeBtns = document.querySelectorAll('[data-mobile-menu-close]');
                const navLinks = document.querySelectorAll('[data-mobile-nav-link]');

                if (! menu || ! openBtn) {
                    return;
                }

                const setOpen = (open) => {
                    menu.hidden = ! open;
                    openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
                    document.body.style.overflow = open ? 'hidden' : '';
                };

                openBtn.addEventListener('click', () => setOpen(true));
                closeBtns.forEach((btn) => btn.addEventListener('click', () => setOpen(false)));
                navLinks.forEach((link) => link.addEventListener('click', () => setOpen(false)));
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && ! menu.hidden) {
                        setOpen(false);
                    }
                });
            })();
        </script>

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
