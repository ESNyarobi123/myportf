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
    <body class="portfolio-shell admin-auth-bg min-h-screen antialiased">
        <div class="flex min-h-svh flex-col items-center justify-center px-4 py-10 sm:px-6">
            <div class="w-full max-w-md">
                <a
                    href="{{ route('home') }}"
                    class="mb-8 flex flex-col items-center gap-3 transition hover:opacity-90"
                    wire:navigate
                >
                    <span class="flex size-14 overflow-hidden rounded-2xl bg-zinc-900 ring-2 ring-zinc-200/80 shadow-lg ring-offset-2 ring-offset-zinc-50 dark:ring-zinc-600 dark:ring-offset-zinc-950">
                        <img src="{{ asset('logo.jpeg') }}" alt="" class="size-full object-cover" width="56" height="56" />
                    </span>
                    <span class="font-display text-lg font-semibold tracking-tight text-zinc-900 dark:text-white">{{ $appName }}</span>
                    <span class="sr-only">{{ __('Back to site') }}</span>
                </a>

                <div
                    class="rounded-2xl border border-zinc-200/90 bg-white/90 p-6 shadow-[0_20px_60px_-28px_rgba(40,36,39,0.35)] backdrop-blur-md dark:border-zinc-700/90 dark:bg-zinc-900/90 dark:shadow-black/40 sm:p-8"
                >
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center font-mono text-[11px] text-zinc-500 dark:text-zinc-400">
                    {{ $brand['role'] ?? 'Full-Stack Software Developer' }}
                </p>
            </div>
        </div>
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
