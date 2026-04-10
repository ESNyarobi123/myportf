<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-4 sm:p-6">
        <div class="flex flex-col gap-1">
            <h1 class="font-display text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ __('Dashboard') }}</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Welcome back. CMS tools will appear here as you build them.') }}</p>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-2xl border border-zinc-200/90 bg-white/50 dark:border-zinc-700/90 dark:bg-zinc-900/40">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-400/30 dark:stroke-zinc-500/30" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-2xl border border-zinc-200/90 bg-white/50 dark:border-zinc-700/90 dark:bg-zinc-900/40">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-400/30 dark:stroke-zinc-500/30" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-2xl border border-zinc-200/90 bg-white/50 dark:border-zinc-700/90 dark:bg-zinc-900/40">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-400/30 dark:stroke-zinc-500/30" />
            </div>
        </div>
        <div class="relative min-h-[12rem] flex-1 overflow-hidden rounded-2xl border border-zinc-200/90 bg-white/50 dark:border-zinc-700/90 dark:bg-zinc-900/40">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-zinc-400/30 dark:stroke-zinc-500/30" />
        </div>
    </div>
</x-layouts::app>
