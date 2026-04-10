@php
    use Illuminate\Support\Str;

    $brand = $portfolio['brand'];
    $aboutHighlights = $portfolio['about_highlights'];
    $proofPoints = $portfolio['proof_points'];
    $stack = $portfolio['stack'];
    $icon = fn (string $name) => "https://api.iconify.design/fluent-color:{$name}.svg";
@endphp

@extends('layouts.portfolio')

@section('title', 'About')

@section('content')
    <section class="dev-hero-gradient border-b border-zinc-200/80 dark:border-zinc-800/80">
        <div class="mx-auto max-w-6xl px-6 pb-12 pt-16 lg:px-8 lg:pb-16 lg:pt-20">
            <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
                <div>
                    <p class="section-kicker-accent">About</p>
                    <h1 class="section-title-lg mt-3">About me</h1>
                    <p class="section-copy mt-5 max-w-xl">{{ $brand['positioning'] }}</p>
                </div>
                <div class="dev-card-flat p-6">
                    <p class="font-mono text-[10px] uppercase tracking-widest text-zinc-500">Status</p>
                    <p class="mt-2 font-display text-xl text-zinc-950 dark:text-white">{{ $brand['availability'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
        <div class="grid gap-5 lg:grid-cols-3">
            @foreach ($aboutHighlights as $highlight)
                <article class="dev-card-flat p-6">
                    <img src="{{ $icon($highlight['icon']) }}" alt="" class="size-10" loading="lazy" width="40" height="40">
                    <h2 class="mt-4 font-display text-xl text-zinc-950 dark:text-white">{{ $highlight['title'] }}</h2>
                    <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ Str::limit($highlight['description'], 120) }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="border-y border-zinc-200/70 bg-white/50 py-16 dark:border-zinc-800/70 dark:bg-zinc-950/30">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1fr_1.1fr]">
                <article class="dev-card-flat p-8">
                    <h2 class="font-display text-2xl text-zinc-950 dark:text-white">Stack &amp; standards</h2>
                    <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">Tools I reach for most days.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach ($stack as $technology)
                            <span class="tag-tech">{{ $technology }}</span>
                        @endforeach
                    </div>
                </article>

                <div class="grid gap-3">
                    @foreach ($proofPoints as $proofPoint)
                        <article class="dev-card-flat flex items-baseline justify-between gap-4 p-5">
                            <span class="font-mono text-[10px] font-medium uppercase tracking-widest text-terra">{{ $proofPoint['label'] }}</span>
                            <p class="text-right text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">{{ Str::limit($proofPoint['value'], 100) }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-20 lg:px-8">
        <div class="dev-card-flat flex flex-col gap-6 p-8 sm:flex-row sm:items-center sm:justify-between">
            <p class="font-display text-xl text-zinc-950 dark:text-white">Like this approach?</p>
            <a
                href="{{ route('contact') }}"
                class="inline-flex rounded-full bg-terra px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600"
            >
                Contact
            </a>
        </div>
    </section>
@endsection
