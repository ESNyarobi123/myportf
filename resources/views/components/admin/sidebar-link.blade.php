@props([
    'href',
    'icon',
    'active' => false,
    'external' => false,
])

@php
    $label = trim(strip_tags($slot->toHtml()));
@endphp

<a
    href="{{ $href }}"
    title="{{ $label }}"
    aria-label="{{ $label }}"
    @if ($active) aria-current="page" @endif
    @unless ($external)
        wire:navigate
    @endunless
    @if ($external)
        target="_blank"
        rel="noreferrer"
    @endif
    @class([
        'admin-sidebar-link group relative my-px flex h-10 w-full min-w-0 items-center gap-3 rounded-xl border px-3 py-0 text-start text-sm font-medium transition-colors lg:h-9',
        'in-data-flux-sidebar-collapsed-desktop:w-10 in-data-flux-sidebar-collapsed-desktop:justify-center in-data-flux-sidebar-collapsed-desktop:gap-0 in-data-flux-sidebar-collapsed-desktop:px-0',
        'border-terra/25 bg-terra/10 text-terra shadow-sm dark:border-white/10 dark:bg-white/[0.08] dark:text-white' => $active,
        'border-transparent text-zinc-600 hover:border-zinc-200 hover:bg-zinc-100/90 dark:text-zinc-400 dark:hover:border-zinc-700 dark:hover:bg-zinc-800/60 dark:hover:text-zinc-100' => ! $active,
    ])
>
    <x-fluent-color-icon
        :name="$icon"
        class="size-6 shrink-0 opacity-95 transition-opacity group-hover:opacity-100 in-data-flux-sidebar-collapsed-desktop:size-[1.35rem]"
    />
    <span class="flex-1 truncate in-data-flux-sidebar-collapsed-desktop:hidden">{{ $slot }}</span>
</a>
