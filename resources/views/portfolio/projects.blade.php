@php
    use Illuminate\Support\Str;

    $projects = $portfolio['projects'];
    $archiveProjects = $portfolio['archive_projects'];
    $icon = fn (string $name) => "https://api.iconify.design/fluent-color:{$name}.svg";
@endphp

@extends('layouts.portfolio')

@section('title', 'Projects')

@section('content')
    <section class="dev-hero-gradient border-b border-zinc-200/80 dark:border-zinc-800/80">
        <div class="mx-auto max-w-6xl px-6 pb-12 pt-16 lg:px-8 lg:pb-16 lg:pt-20">
            <p class="section-kicker-accent">Work</p>
            <h1 class="section-title-lg mt-3 max-w-[14ch]">Projects</h1>
            <p class="section-copy mt-4 max-w-lg">Case studies from shipped products and internal tools.</p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
        <div class="grid gap-5 lg:grid-cols-3">
            @foreach ($projects as $project)
                @php
                    $thumbUrl = $project['thumbnail_url'] ?? null;
                @endphp
                <article class="dev-card-flat flex h-full flex-col overflow-hidden p-0 transition hover:border-terra/30">
                    <a href="{{ route('projects.show', $project['slug']) }}" class="relative block aspect-[16/10] overflow-hidden bg-zinc-100 dark:bg-zinc-800/80">
                        @if (! empty($thumbUrl))
                            <img
                                src="{{ $thumbUrl }}"
                                alt=""
                                class="size-full object-cover transition duration-300 hover:scale-[1.02]"
                                loading="lazy"
                                width="640"
                                height="400"
                            />
                        @else
                            <div class="flex size-full items-center justify-center">
                                <img src="{{ $icon($project['icon']) }}" alt="" class="size-16 opacity-50" loading="lazy" width="64" height="64" />
                            </div>
                        @endif
                    </a>
                    <div class="flex flex-1 flex-col p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-mono text-[10px] font-medium uppercase tracking-widest text-terra">{{ $project['eyebrow'] }}</p>
                            <h2 class="mt-2 font-display text-2xl tracking-tight text-zinc-950 dark:text-white">
                                <a href="{{ route('projects.show', $project['slug']) }}" class="transition hover:text-terra">
                                    {{ $project['title'] }}
                                </a>
                            </h2>
                        </div>
                        @if (empty($thumbUrl))
                            <img src="{{ $icon($project['icon']) }}" alt="" class="size-11 shrink-0" loading="lazy" width="44" height="44" />
                        @endif
                    </div>

                    <p class="mt-4 flex-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ Str::limit($project['summary'], 130) }}</p>

                    <div class="mt-5 flex flex-wrap gap-1.5">
                        @foreach ($project['stack'] as $technology)
                            <span class="tag-tech text-[10px]">{{ $technology }}</span>
                        @endforeach
                    </div>

                    <a
                        href="{{ route('projects.show', $project['slug']) }}"
                        class="mt-6 font-mono text-[11px] font-semibold text-terra"
                    >
                        Read case study →
                    </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="border-y border-zinc-200/70 bg-white/50 py-16 dark:border-zinc-800/70 dark:bg-zinc-950/30">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="section-kicker">Archive</p>
                    <h2 class="mt-2 font-display text-2xl text-zinc-950 dark:text-white">More builds</h2>
                </div>
            </div>

            <div class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($archiveProjects as $project)
                    <article class="dev-card-flat flex items-start gap-3 p-4">
                        <img src="{{ $icon($project['icon']) }}" alt="" class="size-9 shrink-0 opacity-90" loading="lazy" width="36" height="36">
                        <div>
                            <span class="font-mono text-[9px] uppercase tracking-wider text-zinc-400">{{ $project['type'] }}</span>
                            <h3 class="mt-1 font-display text-lg text-zinc-950 dark:text-white">{{ $project['title'] }}</h3>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-20 lg:px-8">
        <div class="dev-card-flat flex flex-col gap-6 p-8 sm:flex-row sm:items-center sm:justify-between">
            <p class="font-display text-xl text-zinc-950 dark:text-white">Need something similar?</p>
            <a
                href="{{ route('contact') }}"
                class="inline-flex shrink-0 items-center justify-center rounded-full bg-terra px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600"
            >
                Get in touch
            </a>
        </div>
    </section>
@endsection
