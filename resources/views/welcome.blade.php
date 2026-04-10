@php
    use Illuminate\Support\Str;

    $brand = $portfolio['brand'];
    $metrics = $portfolio['metrics'];
    $projects = $portfolio['projects'];
    $services = array_slice($portfolio['services'], 0, 3);
    $stack = $portfolio['stack'];
    $featuredProject = $projects[0];
    $secondaryProjects = array_slice($projects, 1);
    $icon = fn (string $name) => "https://api.iconify.design/fluent-color:{$name}.svg";
@endphp

@extends('layouts.portfolio')

@section('title', 'Portfolio')

@section('content')
    {{-- Hero --}}
    <section class="dev-hero-gradient border-b border-zinc-200/80 dark:border-zinc-800/80">
        <div class="mx-auto max-w-6xl px-6 pb-20 pt-14 lg:px-8 lg:pb-28 lg:pt-20">
            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-14">
                <div class="space-y-8 lg:col-span-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="tag-tech border-terra/25 bg-terra/10 text-terra">Available</span>
                        <span class="tag-tech">{{ $brand['hero_stack_pill'] ?? 'Laravel · APIs · Livewire' }}</span>
                    </div>

                    <div class="space-y-4">
                        <p class="font-mono text-sm font-medium text-terra">
                            {{ $brand['nickname'] ?? 'ERICKsky' }} <span class="text-zinc-400">· full-stack</span>
                        </p>
                        <h1 class="hero-title max-w-xl">
                            I build <span class="text-gradient-terra">full-stack web apps</span> and software.
                        </h1>
                        <p class="max-w-lg text-[14px] leading-relaxed text-zinc-600 dark:text-zinc-400">
                            {{ $brand['summary'] }}
                        </p>
                        @if (! empty($brand['hero_focus']))
                            <div class="flex flex-wrap gap-1.5 pt-1">
                                @foreach ($brand['hero_focus'] as $focus)
                                    <span class="tag-tech text-[10px]">{{ $focus }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a
                            href="{{ route('projects') }}"
                            class="inline-flex items-center justify-center rounded-full bg-terra px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600"
                        >
                            View work
                        </a>
                        <a
                            href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center rounded-full border border-zinc-300 bg-white/80 px-6 py-2.5 text-sm font-semibold text-zinc-800 transition hover:border-terra/40 hover:text-terra dark:border-zinc-600 dark:bg-zinc-900/60 dark:text-zinc-100"
                        >
                            Contact
                        </a>
                    </div>

                    <dl class="grid grid-cols-3 gap-4 border-t border-zinc-200/80 pt-8 dark:border-zinc-800/80">
                        @foreach ($metrics as $metric)
                            <div>
                                <dd class="font-display text-2xl tracking-tight text-zinc-950 dark:text-white sm:text-3xl">{{ $metric['value'] }}</dd>
                                <dt class="mt-1 font-mono text-[10px] uppercase tracking-wider text-zinc-500">{{ $metric['label'] }}</dt>
                            </div>
                        @endforeach
                    </dl>

                    <div class="dev-terminal">
                        <div class="dev-terminal-bar">
                            <span class="size-2.5 rounded-full bg-red-400/90"></span>
                            <span class="size-2.5 rounded-full bg-amber-400/90"></span>
                            <span class="size-2.5 rounded-full bg-emerald-400/90"></span>
                            <span class="ml-auto font-mono text-[10px] text-zinc-500">~/{{ Str::lower($brand['nickname'] ?? 'ericksky') }}</span>
                        </div>
                        <div class="space-y-4 p-5 font-mono text-[13px] leading-relaxed text-zinc-400">
                            <p><span class="text-emerald-400/90">➜</span> <span class="text-sky-400/90">~</span> focus</p>
                            <p class="text-zinc-300">Web, mobile, automations, networks &amp; server ops.</p>
                            <p class="pt-2 text-zinc-500">
                                <span class="text-zinc-600">//</span> featured
                            </p>
                            <a
                                href="{{ route('projects.show', $featuredProject['slug']) }}"
                                class="flex gap-3 rounded-lg border border-zinc-800 bg-zinc-900/50 p-3 transition hover:border-terra/40"
                            >
                                @if (! empty($featuredProject['thumbnail_url'] ?? null))
                                    <img
                                        src="{{ $featuredProject['thumbnail_url'] }}"
                                        alt=""
                                        class="size-14 shrink-0 rounded-md object-cover"
                                        loading="lazy"
                                        width="56"
                                        height="56"
                                    />
                                @endif
                                <span class="min-w-0 flex-1">
                                    <span class="text-[10px] font-medium uppercase tracking-widest text-terra">{{ $featuredProject['eyebrow'] }}</span>
                                    <span class="mt-1 block text-base font-semibold text-zinc-100">{{ $featuredProject['title'] }}</span>
                                    <span class="mt-2 block text-xs text-zinc-500">{{ Str::limit($featuredProject['summary'], 72) }}</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="hero-photo-wrap mx-auto w-full lg:col-span-6 lg:items-end lg:pr-4">
                    <div class="hero-photo-frame">
                        <img
                            src="{{ asset('Me.jpeg') }}"
                            alt="Erick — {{ $brand['nickname'] ?? 'ERICKsky' }}, full-stack developer"
                            class="hero-photo-crop"
                            loading="eager"
                            fetchpriority="high"
                            width="400"
                            height="520"
                        />
                    </div>
                    <div
                        class="relative z-[2] mt-5 flex w-full max-w-[17.5rem] items-center gap-3 rounded-2xl border border-zinc-200/90 bg-white/90 px-4 py-3 shadow-sm backdrop-blur-sm dark:border-zinc-700/90 dark:bg-zinc-900/90"
                    >
                        <span class="flex size-10 shrink-0 overflow-hidden rounded-xl ring-1 ring-zinc-200/80 dark:ring-zinc-600">
                            <img src="{{ asset('logo.jpeg') }}" alt="" class="size-full object-cover" width="40" height="40" />
                        </span>
                        <div class="min-w-0">
                            <p class="font-mono text-[11px] font-medium text-terra">{{ '@'.($brand['nickname'] ?? 'ERICKsky') }}</p>
                            <p class="truncate text-sm font-semibold text-zinc-900 dark:text-white">{{ $brand['role'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stack --}}
    <section class="border-b border-zinc-200/70 bg-white/50 dark:border-zinc-800/70 dark:bg-zinc-950/30">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-8 gap-y-3 px-6 py-8 lg:px-8">
            <span class="font-mono text-[10px] font-medium uppercase tracking-[0.2em] text-zinc-400">Stack</span>
            <div class="flex flex-wrap gap-2">
                @foreach ($stack as $tool)
                    <span class="tag-tech">{{ $tool }}</span>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured projects --}}
    <section class="mx-auto max-w-6xl px-6 py-20 lg:px-8 lg:py-28">
        <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
            <div class="space-y-2">
                <p class="section-kicker-accent">Portfolio</p>
                <h2 class="section-title text-3xl sm:text-4xl">Featured projects</h2>
            </div>
            <a
                href="{{ route('projects') }}"
                class="font-mono text-xs font-medium text-zinc-500 underline decoration-zinc-300 underline-offset-4 transition hover:text-terra dark:text-zinc-400 dark:decoration-zinc-600"
            >
                All projects →
            </a>
        </div>

        <div class="mt-12 grid gap-5 lg:grid-cols-12 lg:gap-6">
            <article class="dev-card-flat group relative flex flex-col overflow-hidden p-0 sm:p-0 lg:col-span-7">
                @if (! empty($featuredProject['thumbnail_url'] ?? null))
                    <a href="{{ route('projects.show', $featuredProject['slug']) }}" class="block aspect-[2/1] max-h-56 overflow-hidden bg-zinc-100 dark:bg-zinc-800/80">
                        <img
                            src="{{ $featuredProject['thumbnail_url'] }}"
                            alt=""
                            class="size-full object-cover transition duration-500 group-hover:scale-[1.02]"
                            loading="lazy"
                            width="800"
                            height="400"
                        />
                    </a>
                @endif
                <div class="flex flex-1 flex-col p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-mono text-[10px] font-medium uppercase tracking-widest text-terra">{{ $featuredProject['eyebrow'] }}</p>
                        <h3 class="mt-3 font-display text-3xl tracking-tight text-zinc-950 dark:text-white">
                            <a href="{{ route('projects.show', $featuredProject['slug']) }}" class="transition group-hover:text-terra">
                                {{ $featuredProject['title'] }}
                            </a>
                        </h3>
                    </div>
                    @if (empty($featuredProject['thumbnail_url'] ?? null))
                        <img src="{{ $icon($featuredProject['icon']) }}" alt="" class="size-12 shrink-0 opacity-90" loading="lazy" width="48" height="48" />
                    @endif
                </div>
                <p class="mt-5 flex-1 text-[15px] leading-relaxed text-zinc-600 dark:text-zinc-400">
                    {{ Str::limit($featuredProject['summary'], 160) }}
                </p>
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($featuredProject['stack'] as $technology)
                        <span class="tag-tech">{{ $technology }}</span>
                    @endforeach
                </div>
                <div class="mt-8">
                    <a
                        href="{{ route('projects.show', $featuredProject['slug']) }}"
                        class="inline-flex items-center font-mono text-xs font-semibold text-terra transition hover:opacity-80"
                    >
                        Read case study →
                    </a>
                </div>
                </div>
            </article>

            <div class="flex flex-col gap-5 lg:col-span-5">
                @foreach ($secondaryProjects as $project)
                    @php
                        $secThumb = $project['thumbnail_url'] ?? null;
                    @endphp
                    <article class="dev-card-flat flex flex-1 flex-row gap-4 p-4 transition hover:border-terra/25 sm:p-5">
                        @if (! empty($secThumb))
                            <a href="{{ route('projects.show', $project['slug']) }}" class="relative h-24 w-32 shrink-0 overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800/80">
                                <img src="{{ $secThumb }}" alt="" class="size-full object-cover" loading="lazy" width="128" height="96" />
                            </a>
                        @endif
                        <div class="flex min-w-0 flex-1 flex-col">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-mono text-[10px] font-medium uppercase tracking-widest text-zinc-500">{{ $project['eyebrow'] }}</p>
                                <h3 class="mt-2 font-display text-xl tracking-tight text-zinc-950 dark:text-white">
                                    <a href="{{ route('projects.show', $project['slug']) }}" class="transition hover:text-terra">{{ $project['title'] }}</a>
                                </h3>
                            </div>
                            @if (empty($secThumb))
                                <img src="{{ $icon($project['icon']) }}" alt="" class="size-10 shrink-0" loading="lazy" width="40" height="40" />
                            @endif
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ Str::limit($project['summary'], 100) }}</p>
                        <a
                            href="{{ route('projects.show', $project['slug']) }}"
                            class="mt-4 font-mono text-[11px] font-semibold text-terra"
                        >
                            Read case study →
                        </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section class="border-y border-zinc-200/70 bg-smoke py-20 text-zinc-100 dark:border-zinc-800/70">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="font-mono text-[11px] font-medium uppercase tracking-[0.2em] text-zinc-500">Services</p>
                    <h2 class="mt-2 font-display text-3xl tracking-tight text-white sm:text-4xl">What I build</h2>
                </div>
                <a href="{{ route('services') }}" class="font-mono text-xs text-zinc-400 transition hover:text-white">View all →</a>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-3">
                @foreach ($services as $service)
                    <article class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 backdrop-blur-sm transition hover:border-white/20">
                        <img src="{{ $icon($service['icon']) }}" alt="" class="size-10 opacity-90" loading="lazy" width="40" height="40">
                        <h3 class="mt-4 font-display text-xl text-white">{{ $service['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-zinc-400">{{ Str::limit($service['description'], 85) }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- About strip --}}
    <section class="mx-auto max-w-6xl px-6 py-20 lg:px-8 lg:py-24">
        <div class="dev-card-flat grid gap-10 p-8 lg:grid-cols-[1fr_auto] lg:items-center lg:p-10">
            <div class="space-y-4">
                <p class="section-kicker-accent">About My Work</p>
                <h2 class="font-display text-2xl tracking-tight text-zinc-950 dark:text-white sm:text-3xl">
                    Useful software, clear structure, calm UI.
                </h2>
                <p class="section-copy max-w-lg">
                    {{ Str::limit($brand['positioning'], 140) }}
                </p>
            </div>
            <div class="flex flex-wrap gap-2 lg:justify-end">
                <span class="tag-tech">Laravel</span>
                <span class="tag-tech">Livewire</span>
                <span class="tag-tech">APIs</span>
                <span class="tag-tech">Product UX</span>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a
                href="{{ route('about') }}"
                class="inline-flex rounded-full border border-zinc-300 px-5 py-2 text-sm font-medium text-zinc-800 transition hover:border-terra/40 hover:text-terra dark:border-zinc-600 dark:text-zinc-200"
            >
                About
            </a>
            <a
                href="{{ route('contact') }}"
                class="inline-flex rounded-full bg-terra px-5 py-2 text-sm font-semibold text-white transition hover:bg-blue-600"
            >
                Let&apos;s talk
            </a>
        </div>
    </section>
@endsection
