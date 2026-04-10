@php
    use Illuminate\Support\Str;

    $icon = fn (string $name) => "https://api.iconify.design/fluent-color:{$name}.svg";
    $thumbUrl = $project['thumbnail_url'] ?? null;
    $galleryUrls = $project['gallery_urls'] ?? [];
    $liveUrl = $project['live_url'] ?? null;
    $githubUrl = $project['github_url'] ?? null;
    $fullDescription = $project['full_description'] ?? null;
    $pageTitle = $project['page_title'] ?? $project['title'];
    $metaDescription = $project['meta_description'] ?? '';
    $canonicalUrl = $project['canonical_url'] ?? route('projects.show', $project['slug']);
    $shareImageUrl = $project['share_image_url'] ?? null;
@endphp

@extends('layouts.portfolio')

@section('title', $pageTitle)

@section('head_extra')
    @if ($metaDescription !== '')
        <meta name="description" content="{{ e($metaDescription) }}" />
    @endif
    <link rel="canonical" href="{{ e($canonicalUrl) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ e($pageTitle) }}" />
    @if ($metaDescription !== '')
        <meta property="og:description" content="{{ e($metaDescription) }}" />
    @endif
    <meta property="og:url" content="{{ e($canonicalUrl) }}" />
    @if ($shareImageUrl)
        <meta property="og:image" content="{{ e($shareImageUrl) }}" />
    @endif
    <meta name="twitter:card" content="{{ $shareImageUrl ? 'summary_large_image' : 'summary' }}" />
    <meta name="twitter:title" content="{{ e($pageTitle) }}" />
    @if ($metaDescription !== '')
        <meta name="twitter:description" content="{{ e($metaDescription) }}" />
    @endif
    @if ($shareImageUrl)
        <meta name="twitter:image" content="{{ e($shareImageUrl) }}" />
    @endif
    @isset($projectJsonLd)
        <script type="application/ld+json">@json($projectJsonLd)</script>
    @endisset
@endsection

@section('content')
    <section class="dev-hero-gradient border-b border-zinc-200/80 dark:border-zinc-800/80">
        <div class="mx-auto max-w-6xl px-6 pb-12 pt-16 lg:px-8 lg:pb-16 lg:pt-20">
            <div class="flex flex-wrap gap-2">
                <span class="tag-tech border-terra/25 bg-terra/10 text-terra">{{ $project['eyebrow'] }}</span>
                <span class="tag-tech">{{ $project['year'] }}</span>
            </div>
            <h1 class="section-title-lg mt-8 max-w-[22ch]">{{ $project['headline'] }}</h1>
            <p class="section-copy mt-6 max-w-2xl text-[16px]">{{ Str::limit($project['summary'], 220) }}</p>
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach ($project['stack'] as $technology)
                    <span class="tag-tech">{{ $technology }}</span>
                @endforeach
            </div>
            @if (! empty($liveUrl) || ! empty($githubUrl))
                <div class="mt-8 flex flex-wrap gap-3">
                    @if (! empty($liveUrl))
                        <a
                            href="{{ $liveUrl }}"
                            target="_blank"
                            rel="noreferrer"
                            class="inline-flex items-center justify-center rounded-full bg-terra px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-600"
                        >
                            {{ __('Live site') }}
                        </a>
                    @endif
                    @if (! empty($githubUrl))
                        <a
                            href="{{ $githubUrl }}"
                            target="_blank"
                            rel="noreferrer"
                            class="inline-flex items-center justify-center rounded-full border border-zinc-300 bg-white/80 px-5 py-2.5 text-sm font-semibold text-zinc-800 transition hover:border-terra/40 hover:text-terra dark:border-zinc-600 dark:bg-zinc-900/60 dark:text-zinc-100"
                        >
                            {{ __('GitHub') }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @if (! empty($thumbUrl))
        <section class="border-b border-zinc-200/80 dark:border-zinc-800/80">
            <div class="mx-auto max-w-6xl px-6 pb-12 lg:px-8">
                <div class="overflow-hidden rounded-2xl border border-zinc-200/90 bg-zinc-100 shadow-sm dark:border-zinc-700/90 dark:bg-zinc-900/40">
                    <img
                        src="{{ $thumbUrl }}"
                        alt=""
                        class="aspect-[21/9] w-full object-cover object-center sm:aspect-[2.4/1]"
                        loading="lazy"
                        width="1200"
                        height="500"
                    />
                </div>
            </div>
        </section>
    @endif

    @if (! empty($fullDescription))
        <section class="mx-auto max-w-6xl px-6 py-12 lg:px-8">
            <article class="dev-card-flat p-8">
                <h2 class="font-display text-xl text-zinc-950 dark:text-white">{{ __('Overview') }}</h2>
                <div class="mt-4 whitespace-pre-line text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                    {{ $fullDescription }}
                </div>
            </article>
        </section>
    @endif

    @if (count($galleryUrls) > 0)
        <section class="mx-auto max-w-6xl px-6 py-8 lg:px-8">
            <p class="section-kicker-accent">{{ __('Gallery') }}</p>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($galleryUrls as $gUrl)
                    <a href="{{ $gUrl }}" target="_blank" rel="noreferrer" class="group block overflow-hidden rounded-xl border border-zinc-200/90 dark:border-zinc-700/90">
                        <img src="{{ $gUrl }}" alt="" class="aspect-video w-full object-cover transition group-hover:opacity-95" loading="lazy" width="800" height="450" />
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-6xl px-6 py-12 lg:px-8">
        <div class="grid gap-5 lg:grid-cols-12">
            <article class="dev-card-flat p-8 lg:col-span-5">
                <p class="font-mono text-[10px] uppercase tracking-widest text-terra">Outcome</p>
                <p class="mt-3 font-display text-3xl text-zinc-950 dark:text-white">{{ $project['metric'] }}</p>
                <p class="mt-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $project['result'] }}</p>
                <div class="mt-6 flex items-center gap-3 border-t border-zinc-200/80 pt-6 dark:border-zinc-800/80">
                    <img src="{{ $icon($project['icon']) }}" alt="" class="size-12 rounded-xl border border-zinc-200/80 dark:border-zinc-700" loading="lazy" width="48" height="48">
                    <div>
                        <p class="font-mono text-[10px] uppercase text-zinc-500">Client</p>
                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $project['client'] }}</p>
                    </div>
                </div>
            </article>

            <div class="grid gap-5 lg:col-span-7">
                <article class="dev-card-flat p-6">
                    <h2 class="font-display text-xl text-zinc-950 dark:text-white">What needed to change</h2>
                    <p class="mt-3 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $project['challenge'] }}</p>
                </article>
                <article class="dev-card-flat p-6">
                    <h2 class="font-display text-xl text-zinc-950 dark:text-white">How the product was shaped</h2>
                    <p class="mt-3 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $project['approach'] }}</p>
                </article>
            </div>
        </div>
    </section>

    <section class="border-y border-zinc-200/70 bg-white/50 py-14 dark:border-zinc-800/70 dark:bg-zinc-950/30">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <p class="section-kicker-accent">Impact</p>
            <div class="mt-8 grid gap-3 lg:grid-cols-3">
                @foreach ($project['impact_points'] as $impactPoint)
                    <article class="dev-card-flat p-5">
                        <p class="text-sm leading-relaxed text-zinc-700 dark:text-zinc-300">{{ $impactPoint }}</p>
                    </article>
                @endforeach
            </div>
            <p class="mt-8 font-mono text-[10px] text-zinc-400">Deliverables: {{ implode(' · ', $project['deliverables']) }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <h2 class="section-title text-2xl sm:text-3xl">Other projects</h2>
        </div>

        <div class="mt-8 grid gap-5 lg:grid-cols-2">
            @foreach ($relatedProjects as $relatedProject)
                @php
                    $relThumb = $relatedProject['thumbnail_url'] ?? null;
                @endphp
                <article class="dev-card-flat flex flex-col overflow-hidden p-0">
                    @if (! empty($relThumb))
                        <a href="{{ route('projects.show', $relatedProject['slug']) }}" class="block aspect-[16/10] overflow-hidden bg-zinc-100 dark:bg-zinc-800/80">
                            <img src="{{ $relThumb }}" alt="" class="size-full object-cover" loading="lazy" width="400" height="250" />
                        </a>
                    @endif
                    <div class="flex flex-1 flex-col p-6">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="font-mono text-[10px] font-medium uppercase tracking-widest text-zinc-500">{{ $relatedProject['eyebrow'] }}</p>
                            <h3 class="mt-2 font-display text-xl text-zinc-950 dark:text-white">{{ $relatedProject['title'] }}</h3>
                        </div>
                        @if (empty($relThumb))
                            <img src="{{ $icon($relatedProject['icon']) }}" alt="" class="size-10 shrink-0" loading="lazy" width="40" height="40" />
                        @endif
                    </div>
                    <p class="mt-3 flex-1 text-sm text-zinc-600 dark:text-zinc-400">{{ Str::limit($relatedProject['summary'], 120) }}</p>
                    <a
                        href="{{ route('projects.show', $relatedProject['slug']) }}"
                        class="mt-5 font-mono text-[11px] font-semibold text-terra"
                    >
                        View project →
                    </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 pb-20 lg:px-8">
        <div class="dev-card-flat flex flex-col gap-5 p-8 sm:flex-row sm:items-center sm:justify-between">
            <p class="font-display text-xl text-zinc-950 dark:text-white">Similar project in mind?</p>
            <a
                href="{{ route('contact') }}"
                class="inline-flex rounded-full bg-terra px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600"
            >
                Contact
            </a>
        </div>
    </section>
@endsection
