@extends('layouts.storefront')

@section('title', 'Studio — '.($siteName ?? 'Yueli Studio'))

@section('content')
    @php
        $introParas = $intro?->body
            ? preg_split("/\n\s*\n/", trim($intro->body))
            : ['Artistic process, fittings, and collaborations beyond the boutique.'];
        $featured = $projects->first();
        $rest = $projects->slice(1)->values();
    @endphp

    {{-- Masthead --}}
    <section class="relative overflow-hidden border-b border-ink/8 bg-porcelain">
        <div class="pointer-events-none absolute inset-0" style="background-image: radial-gradient(ellipse 60% 50% at 100% 0%, rgba(254,112,163,0.22), transparent 55%), radial-gradient(ellipse 45% 40% at 0% 100%, rgba(247,162,197,0.18), transparent 50%);"></div>
        <div class="deco-dots opacity-50" aria-hidden="true"></div>
        <div class="glow-orb pointer-events-none absolute -right-10 top-10 h-56 w-56 opacity-30"></div>

        <div class="relative mx-auto max-w-[90rem] px-5 py-16 lg:px-10 lg:py-24">
            <div class="fade-up ornament mb-8">
                <span class="ornament-mark text-primary">✦</span>
            </div>

            <div class="grid gap-10 lg:grid-cols-12 lg:items-end">
                <div class="lg:col-span-8">
                    <p class="fade-up text-[11px] uppercase tracking-[0.3em] text-primary">
                        {{ $intro->subtitle ?? 'Selected work' }}
                        <span class="text-ink/20"> · </span>
                        <span class="text-mist">House archive</span>
                    </p>
                    <h1 class="fade-up reveal-delay-1 mt-4 font-display text-[clamp(2.75rem,11vw,7.5rem)] font-medium italic leading-[0.88] tracking-[0.01em] text-ink">
                        Studio
                    </h1>
                    <div class="fade-up reveal-delay-2 mt-6 flex items-center gap-4">
                        <span class="editorial-rule max-w-[6rem] bg-primary"></span>
                        <span class="text-[10px] uppercase tracking-[0.24em] text-mist">
                            {{ $projects->count() }} {{ \Illuminate\Support\Str::plural('study', $projects->count()) }}
                        </span>
                    </div>
                </div>
                <div class="fade-up reveal-delay-3 lg:col-span-4">
                    <div class="panel-soft rounded-[24px] border border-primary/15 p-6 md:p-7">
                        <p class="font-serif text-lg leading-relaxed text-ink/65 md:text-xl">
                            {{ $introParas[0] }}
                        </p>
                        <a href="{{ route('contact') }}" class="mt-5 inline-flex text-[10px] uppercase tracking-[0.22em] text-primary transition hover:text-accent">
                            Commission →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured study --}}
    @if($featured)
        <section class="relative overflow-hidden bg-soft/30 py-12 lg:py-16">
            <div class="glow-orb-sky pointer-events-none absolute -left-20 top-1/3 h-64 w-64 opacity-25"></div>
            <div class="relative mx-auto max-w-5xl px-5 lg:px-10">
                <div class="fade-up mb-6 flex items-center justify-between gap-4">
                    <p class="section-label text-primary">Featured study</p>
                    <span class="rounded-full bg-primary/15 px-3 py-1 text-[9px] uppercase tracking-[0.2em] text-primary">01</span>
                </div>

                <a href="{{ route('portfolio.show', $featured) }}" class="reveal group relative block overflow-hidden rounded-[28px] shadow-[0_28px_60px_-20px_rgba(254,112,163,0.5)] ring-1 ring-primary/20">
                    <div class="relative aspect-[16/11] max-h-[26rem] overflow-hidden bg-blush sm:aspect-[21/11] sm:max-h-[28rem]">
                        @if($featured->coverUrl())
                            <img src="{{ $featured->coverUrl() }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]">
                        @else
                            <div class="h-full bg-gradient-to-br from-soft to-primary/50"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-ink/85 via-ink/45 to-transparent"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-ink/50 via-transparent to-transparent"></div>

                        <div class="absolute inset-0 flex flex-col justify-end p-6 md:p-10 lg:max-w-xl">
                            <p class="text-[10px] uppercase tracking-[0.26em] text-primary">
                                {{ collect([$featured->client, $featured->year])->filter()->implode(' · ') ?: 'Studio study' }}
                            </p>
                            <h2 class="mt-3 font-display text-4xl italic text-porcelain md:text-5xl lg:text-6xl">
                                {{ $featured->title }}
                            </h2>
                            @if($featured->role)
                                <p class="mt-3 text-[10px] uppercase tracking-[0.2em] text-soft">{{ $featured->role }}</p>
                            @endif
                            @if($featured->excerpt)
                                <p class="mt-4 font-serif text-base leading-relaxed text-porcelain/70 md:text-lg">
                                    {{ \Illuminate\Support\Str::limit($featured->excerpt, 120) }}
                                </p>
                            @endif
                            <span class="mt-6 inline-flex w-fit items-center gap-2 rounded-full bg-primary px-5 py-2.5 text-[10px] uppercase tracking-[0.2em] text-white shadow-[0_10px_24px_-10px_rgba(254,112,163,0.7)] transition group-hover:bg-accent">
                                Open study →
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </section>
    @endif

    {{-- Remaining studies as polished cards --}}
    @if($rest->isNotEmpty())
        <section class="relative overflow-hidden border-y border-ink/8 bg-porcelain py-14 lg:py-20">
            <div class="pointer-events-none absolute inset-0 opacity-50" style="background-image: radial-gradient(ellipse at 50% 0%, rgba(254,112,163,0.08), transparent 45%);"></div>
            <div class="relative mx-auto max-w-5xl px-5 lg:px-10">
                <div class="fade-up mb-10 flex items-end justify-between gap-4">
                    <div>
                        <p class="section-label text-primary">More studies</p>
                        <h2 class="mt-3 font-serif text-3xl italic text-ink md:text-4xl">In the archive</h2>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 sm:gap-7">
                    @foreach($rest as $index => $project)
                        <a href="{{ route('portfolio.show', $project) }}" class="reveal group {{ 'reveal-delay-'.(($index % 2) + 1) }}">
                            <div class="relative overflow-hidden rounded-[22px] shadow-[0_18px_42px_-16px_rgba(254,112,163,0.42)] ring-1 ring-primary/10 transition duration-500 group-hover:-translate-y-1 group-hover:ring-primary/30">
                                <div class="relative aspect-[4/5] max-h-80 overflow-hidden bg-blush">
                                    @if($project->coverUrl())
                                        <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]">
                                    @else
                                        <div class="h-full bg-gradient-to-br from-soft to-primary/40"></div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-ink/20 to-transparent"></div>

                                    <span class="absolute left-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-porcelain/95 font-display text-lg italic text-primary shadow-[0_8px_18px_-8px_rgba(254,112,163,0.55)] backdrop-blur-sm">
                                        {{ str_pad((string) ($index + 2), 2, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <div class="absolute inset-x-0 bottom-0 p-5">
                                        <p class="text-[10px] uppercase tracking-[0.22em] text-primary">
                                            {{ collect([$project->client, $project->year])->filter()->implode(' · ') }}
                                        </p>
                                        <h3 class="mt-2 font-serif text-2xl italic text-porcelain md:text-3xl">{{ $project->title }}</h3>
                                        @if($project->role)
                                            <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-soft">{{ $project->role }}</p>
                                        @endif
                                        @if($project->excerpt)
                                            <p class="mt-3 line-clamp-2 font-serif text-sm leading-relaxed text-porcelain/65">
                                                {{ $project->excerpt }}
                                            </p>
                                        @endif
                                        <p class="mt-4 text-[10px] uppercase tracking-[0.2em] text-porcelain/80 transition group-hover:text-primary">
                                            View study →
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($projects->isEmpty())
        <section class="px-5 py-24 text-center">
            <div class="ornament mb-6 justify-center">
                <span class="ornament-mark text-primary">✦</span>
            </div>
            <p class="font-serif text-3xl italic text-ink">Projects coming soon</p>
            <a href="{{ route('contact') }}" class="btn-ghost mt-8 inline-flex">Start a collaboration</a>
        </section>
    @endif

    {{-- Process + index --}}
    <section class="relative overflow-hidden bg-soft/25">
        <div class="glow-orb pointer-events-none absolute right-0 top-0 h-48 w-48 opacity-20"></div>
        <div class="relative mx-auto max-w-5xl px-5 py-16 lg:px-10 lg:py-20">
            @if(count($introParas) > 1)
                <div class="fade-up mb-14 text-center">
                    <div class="ornament mb-5 justify-center">
                        <span class="ornament-mark text-primary">❧</span>
                    </div>
                    <p class="section-label justify-center text-primary">Process</p>
                    <div class="mx-auto mt-6 max-w-2xl space-y-4 font-serif text-lg leading-relaxed text-ink/60">
                        @foreach(array_slice($introParas, 1) as $para)
                            <p>{{ $para }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($projects->isNotEmpty())
                <div class="fade-up panel-soft overflow-hidden rounded-[24px] border border-primary/15">
                    <div class="border-b border-primary/10 px-5 py-4 md:px-7">
                        <div class="flex items-center justify-between gap-3">
                            <h2 class="font-serif text-2xl italic text-ink md:text-3xl">Index</h2>
                            <span class="text-[10px] uppercase tracking-[0.2em] text-mist">All studies</span>
                        </div>
                    </div>
                    <ul>
                        @foreach($projects as $index => $project)
                            <li class="border-b border-ink/8 last:border-0">
                                <a href="{{ route('portfolio.show', $project) }}" class="group flex items-center gap-4 px-5 py-4 transition hover:bg-primary/5 md:gap-6 md:px-7 md:py-5">
                                    <span class="font-display text-2xl italic text-primary">
                                        {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    @if($project->coverUrl())
                                        <span class="hidden h-12 w-9 shrink-0 overflow-hidden rounded-[8px] shadow-sm sm:block">
                                            <img src="{{ $project->coverUrl() }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                        </span>
                                    @endif
                                    <span class="min-w-0 flex-1">
                                        <span class="block font-serif text-xl italic text-ink transition group-hover:text-primary md:text-2xl">{{ $project->title }}</span>
                                        <span class="mt-0.5 block text-[10px] uppercase tracking-[0.18em] text-mist">
                                            {{ collect([$project->role, $project->year])->filter()->implode(' · ') }}
                                        </span>
                                    </span>
                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-primary/25 text-primary transition group-hover:border-primary group-hover:bg-primary group-hover:text-white">
                                        →
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-ink text-porcelain">
        <div class="hero-sparks opacity-30" aria-hidden="true"></div>
        <div class="glow-orb pointer-events-none absolute -right-16 top-1/2 h-56 w-56 -translate-y-1/2 opacity-35"></div>
        <div class="relative mx-auto flex max-w-[90rem] flex-col gap-8 px-5 py-16 md:flex-row md:items-center md:justify-between lg:px-10 lg:py-20">
            <div>
                <div class="ornament mb-5 justify-start">
                    <span class="ornament-mark text-primary">✦</span>
                </div>
                <p class="font-display text-4xl italic md:text-5xl">Commission the atelier.</p>
                <p class="mt-3 max-w-md font-serif text-lg text-porcelain/55">Fittings, campaigns, and private capsules.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('contact') }}" class="btn-rose">Contact studio</a>
                <a href="{{ route('lookbook.index') }}" class="btn-outline">Lookbook</a>
            </div>
        </div>
    </section>
@endsection
