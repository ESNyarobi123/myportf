@php
    $contactChannels = $portfolio['contact_channels'];
    $availability = $portfolio['availability'];
    $icon = fn (string $name) => "https://api.iconify.design/fluent-color:{$name}.svg";
@endphp

@extends('layouts.portfolio')

@section('title', 'Contact')

@section('content')
    <section class="dev-hero-gradient border-b border-zinc-200/80 dark:border-zinc-800/80">
        <div class="mx-auto max-w-6xl px-6 pb-12 pt-16 lg:px-8 lg:pb-16 lg:pt-20">
            <p class="section-kicker-accent">Contact</p>
            <h1 class="section-title-lg mt-3 max-w-[16ch]">Let's work together.</h1>
            <p class="section-copy mt-4 max-w-md">Short intro — then email or WhatsApp works best.</p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[1fr_1.1fr]">
            <div class="space-y-6">
                <article class="dev-card-flat p-8">
                    <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">Availability</p>
                    <h2 class="mt-3 font-display text-2xl text-zinc-950 dark:text-white">{{ $availability['headline'] }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $availability['summary'] }}</p>
                </article>

                <div class="flex flex-wrap gap-2">
                    @foreach ($availability['notes'] as $note)
                        <span class="tag-tech">{{ $note }}</span>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-3">
                @foreach ($contactChannels as $channel)
                    <a
                        href="{{ $channel['href'] }}"
                        class="dev-card-flat flex items-start gap-4 p-5 transition hover:border-terra/35"
                        target="_blank"
                        rel="noreferrer"
                    >
                        <img src="{{ $icon($channel['icon']) }}" alt="" class="mt-0.5 size-10 shrink-0" loading="lazy" width="40" height="40">
                        <div class="min-w-0 flex-1">
                            <p class="font-mono text-[10px] font-medium uppercase tracking-widest text-zinc-500">{{ $channel['label'] }}</p>
                            <p class="mt-1 font-semibold text-zinc-950 dark:text-white">{{ $channel['value'] }}</p>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $channel['note'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 pb-20 lg:px-8">
        <livewire:portfolio.contact-form />
    </section>
@endsection
