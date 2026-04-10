<section class="flex h-full w-full flex-1 flex-col gap-6 p-4 sm:p-6">
    <div class="flex flex-col gap-1">
        <h1 class="font-display text-2xl font-semibold tracking-tight text-zinc-900 dark:text-white">{{ __('Portfolio CMS') }}</h1>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Structured content — projects, services, profile, and inquiries. Expand modules as you grow.') }}
        </p>
    </div>

    <div class="flex flex-wrap gap-x-5 gap-y-2 border-b border-zinc-200/80 pb-4 text-sm dark:border-zinc-700/80">
        <a href="{{ route('admin.projects') }}" wire:navigate class="font-medium text-terra hover:underline">{{ __('Projects') }}</a>
        <a href="{{ route('admin.services') }}" wire:navigate class="font-medium text-zinc-600 hover:text-terra dark:text-zinc-400">{{ __('Services') }}</a>
        <a href="{{ route('admin.site-profile') }}" wire:navigate class="font-medium text-zinc-600 hover:text-terra dark:text-zinc-400">{{ __('Site profile') }}</a>
        <a href="{{ route('admin.inquiries') }}" wire:navigate class="font-medium text-zinc-600 hover:text-terra dark:text-zinc-400">{{ __('Inquiries') }}</a>
        <a href="{{ route('admin.media') }}" wire:navigate class="font-medium text-zinc-600 hover:text-terra dark:text-zinc-400">{{ __('Media') }}</a>
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="font-medium text-zinc-600 hover:text-terra dark:text-zinc-400">{{ __('Public site') }}</a>
    </div>

    @if ($draftProjectCount > 0 || $publishedMissingThumbnailCount > 0)
        <div class="dev-card-flat rounded-2xl border border-amber-200/90 bg-amber-50/80 p-4 dark:border-amber-900/50 dark:bg-amber-950/30">
            <p class="font-mono text-[10px] font-semibold uppercase tracking-widest text-amber-800 dark:text-amber-200/90">{{ __('Needs attention') }}</p>
            <ul class="mt-3 list-inside list-disc space-y-1 text-sm text-amber-950 dark:text-amber-100/90">
                @if ($draftProjectCount > 0)
                    <li>
                        {{ trans_choice(':count draft project needs publishing.|:count draft projects need publishing.', $draftProjectCount, ['count' => $draftProjectCount]) }}
                        <a href="{{ route('admin.projects') }}" wire:navigate class="ml-1 font-medium text-terra underline-offset-2 hover:underline">{{ __('Review →') }}</a>
                    </li>
                @endif
                @if ($publishedMissingThumbnailCount > 0)
                    <li>
                        {{ trans_choice(':count published project has no thumbnail (cards use the icon fallback).|:count published projects have no thumbnail (cards use the icon fallback).', $publishedMissingThumbnailCount, ['count' => $publishedMissingThumbnailCount]) }}
                        @if ($publishedMissingThumbnailTitles->isNotEmpty())
                            <span class="block pl-4 font-mono text-[11px] text-amber-900/80 dark:text-amber-200/70">
                                {{ $publishedMissingThumbnailTitles->pluck('title')->join(' · ') }}
                                @if ($publishedMissingThumbnailCount > $publishedMissingThumbnailTitles->count())
                                    {{ __('…') }}
                                @endif
                            </span>
                        @endif
                        <a href="{{ route('admin.projects') }}" wire:navigate class="ml-1 font-medium text-terra underline-offset-2 hover:underline">{{ __('Add images →') }}</a>
                    </li>
                @endif
            </ul>
        </div>
    @endif

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a
            href="{{ route('admin.projects') }}"
            wire:navigate
            class="dev-card-flat flex flex-col gap-2 rounded-2xl border border-zinc-200/90 p-5 transition hover:border-terra/30 dark:border-zinc-700/90"
        >
            <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">{{ __('Projects') }}</p>
            <p class="font-display text-3xl text-zinc-950 dark:text-white">{{ $projectCount }}</p>
            <p class="text-xs text-terra">{{ __('Manage case studies →') }}</p>
        </a>
        <a
            href="{{ route('admin.services') }}"
            wire:navigate
            class="dev-card-flat flex flex-col gap-2 rounded-2xl border border-zinc-200/90 p-5 transition hover:border-terra/30 dark:border-zinc-700/90"
        >
            <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">{{ __('Services') }}</p>
            <p class="font-display text-3xl text-zinc-950 dark:text-white">{{ $serviceCount }}</p>
            <p class="text-xs text-terra">{{ __('Manage offerings →') }}</p>
        </a>
        <a
            href="{{ route('admin.inquiries') }}"
            wire:navigate
            class="dev-card-flat flex flex-col gap-2 rounded-2xl border border-zinc-200/90 p-5 transition hover:border-terra/30 dark:border-zinc-700/90"
        >
            <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">{{ __('Inquiries') }}</p>
            <p class="font-display text-3xl text-zinc-950 dark:text-white">{{ $inquiryCount }}</p>
            <p class="text-xs text-terra">{{ __('Contact messages →') }}</p>
        </a>
        <a
            href="{{ route('admin.media') }}"
            wire:navigate
            class="dev-card-flat flex flex-col gap-2 rounded-2xl border border-zinc-200/90 p-5 transition hover:border-terra/30 dark:border-zinc-700/90"
        >
            <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">{{ __('Media') }}</p>
            <p class="font-display text-3xl text-zinc-950 dark:text-white">{{ $mediaCount }}</p>
            <p class="text-xs text-terra">{{ __('Library →') }}</p>
        </a>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="dev-card-flat rounded-2xl border border-zinc-200/90 p-6 dark:border-zinc-700/90">
            <div class="flex items-start justify-between gap-3">
                <h2 class="font-display text-lg text-zinc-950 dark:text-white">{{ __('Recent inquiries') }}</h2>
                <a href="{{ route('admin.inquiries') }}" wire:navigate class="shrink-0 font-mono text-[11px] font-semibold text-terra hover:underline">{{ __('View all') }}</a>
            </div>
            @if ($recentInquiries->isEmpty())
                <p class="mt-4 text-sm text-zinc-600 dark:text-zinc-400">{{ __('No messages yet. They will appear here when someone uses the contact form.') }}</p>
            @else
                <ul class="mt-4 divide-y divide-zinc-200/80 dark:divide-zinc-700/80">
                    @foreach ($recentInquiries as $inquiry)
                        <li class="flex flex-col gap-0.5 py-3 first:pt-0 last:pb-0">
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $inquiry->name }}</span>
                            <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ $inquiry->email }}</span>
                            <span class="font-mono text-[10px] uppercase tracking-wider text-zinc-400 dark:text-zinc-500">
                                {{ $inquiry->created_at?->timezone(config('app.timezone'))->format('M j, Y g:i a') }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="dev-card-flat rounded-2xl border border-zinc-200/90 p-6 dark:border-zinc-700/90">
            <h2 class="font-display text-lg text-zinc-950 dark:text-white">{{ __('Site & SEO') }}</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Brand copy, contact channels, and SEO defaults live in Site profile.') }}
            </p>
            <flux:button class="mt-4" variant="primary" :href="route('admin.site-profile')" wire:navigate>
                {{ __('Open site profile') }}
            </flux:button>
        </div>
        <div class="dev-card-flat rounded-2xl border border-zinc-200/90 p-6 dark:border-zinc-700/90">
            <h2 class="font-display text-lg text-zinc-950 dark:text-white">{{ __('Public site') }}</h2>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ __('Preview how visitors see your portfolio.') }}</p>
            <flux:button class="mt-4" variant="ghost" :href="route('home')" target="_blank">
                {{ __('Open homepage') }}
            </flux:button>
        </div>
    </div>
</section>
