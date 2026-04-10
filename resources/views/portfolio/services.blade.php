@php
    use Illuminate\Support\Str;

    $services = $portfolio['services'];
    $capabilities = $portfolio['capabilities'];
    $workflow = $portfolio['workflow'];
    $icon = fn (string $name) => "https://api.iconify.design/fluent-color:{$name}.svg";
@endphp

@extends('layouts.portfolio')

@section('title', 'Services')

@section('content')
    <section class="dev-hero-gradient border-b border-zinc-200/80 dark:border-zinc-800/80">
        <div class="mx-auto max-w-6xl px-6 pb-12 pt-16 lg:px-8 lg:pb-16 lg:pt-20">
            <p class="section-kicker-accent">Services</p>
            <h1 class="section-title-lg mt-3 max-w-[18ch]">What I build</h1>
            <p class="section-copy mt-4 max-w-xl">Full-stack delivery: systems, dashboards, and integrations.</p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($services as $service)
                <article class="dev-card-flat p-6 transition hover:border-terra/25">
                    <img src="{{ $icon($service['icon']) }}" alt="" class="size-10 opacity-90" loading="lazy" width="40" height="40">
                    <h2 class="mt-4 font-display text-xl tracking-tight text-zinc-950 dark:text-white">{{ $service['title'] }}</h2>
                    <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ Str::limit($service['description'], 120) }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section class="border-y border-zinc-200/70 bg-smoke py-20 text-zinc-100 dark:border-zinc-800/70">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <div class="max-w-xl">
                <p class="font-mono text-[11px] font-medium uppercase tracking-[0.2em] text-zinc-500">How I work</p>
                <h2 class="mt-2 font-display text-3xl text-white">Capabilities</h2>
                <p class="mt-3 text-sm text-zinc-400">Backend, UI, and delivery in one loop.</p>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach ($capabilities as $capability)
                    <article class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 backdrop-blur-sm">
                        <img src="{{ $icon($capability['icon']) }}" alt="" class="size-10" loading="lazy" width="40" height="40">
                        <h3 class="mt-4 font-display text-xl text-white">{{ $capability['title'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-400">{{ Str::limit($capability['description'], 100) }}</p>
                        <ul class="mt-4 space-y-2 border-t border-white/10 pt-4 font-mono text-[11px] text-zinc-300">
                            @foreach ($capability['items'] as $item)
                                <li class="flex gap-2">
                                    <span class="text-terra">—</span>
                                    <span>{{ Str::limit($item, 70) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-20 lg:px-8">
        <p class="section-kicker-accent">Process</p>
        <h2 class="section-title mt-2 text-3xl sm:text-4xl">From idea to launch</h2>

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($workflow as $step)
                <article class="dev-card-flat p-5">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[10px] text-zinc-400">0{{ $loop->iteration }}</span>
                        <img src="{{ $icon($step['icon']) }}" alt="" class="size-8 opacity-80" loading="lazy" width="32" height="32">
                    </div>
                    <h3 class="mt-4 font-display text-lg text-zinc-950 dark:text-white">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ Str::limit($step['description'], 90) }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
