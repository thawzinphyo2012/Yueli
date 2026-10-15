@extends('layouts.storefront')

@section('title', $project->title.' — '.($siteName ?? 'Yueli Studio'))

@section('content')
    @php
        $bodyParas = $project->body
            ? preg_split("/\n\s*\n/", trim($project->body))
            : [];
        $gallery = collect($project->gallery ?? [])->filter()->values();
    @endphp

    {{-- Cinematic study hero --}}
    <section class="relative min-h-[78vh] overflow-hidden bg-ink text-porcelain">
        @if($project->coverUrl())
            <img src="{{ $project->coverUrl() }}" alt="" class="ken-burns absolute inset-0 h-full w-full object-cover opacity-55">
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-ink via-ink/80 to-primary/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-ink via-ink/20 to-ink/50"></div>
        <div class="hero-sparks opacity-50" aria-hidden="true"></div>
        <div class="deco-dots opacity-40" aria-hidden="true"></div>
        <div class="glow-orb right-[12%] top-[20%] h-72 w-72 opacity-35"></div>
        <div class="glow-orb-sky bottom-[10%] left-[5%] h-44 w-44 opacity-25" style="animation-delay: 1.2s"></div>

        <div class="relative z-10 mx-auto flex min-h-[78vh] max-w-[90rem] flex-col justify-between px-5 pb-14 pt-28 lg:px-10 lg:pb-16">
            <a href="{{ route('portfolio.index') }}" class="fade-up inline-flex min-h-11 w-fit items-center gap-2 rounded-full border border-porcelain/20 bg-ink/30 px-4 py-2 text-[10px] uppercase tracking-[0.24em] text-porcelain/70 backdrop-blur-sm transition hover:border-primary hover:text-primary">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                Studio
            </a>

            <div class="mt-auto max-w-3xl">
                <div class="fade-up ornament mb-5 justify-start">
                    <span class="ornament-mark text-primary">✦</span>
                </div>
                @if($project->client || $project->year)
                    <p class="fade-up text-[11px] uppercase tracking-[0.28em] text-primary">
                        {{ collect([$project->client, $project->year])->filter()->implode(' · ') }}
                    </p>
                @endif
                <h1 class="fade-up reveal-delay-1 mt-4 font-display text-5xl font-medium italic leading-[1.05] md:text-6xl lg:text-7xl">
                    {{ $project->title }}
                </h1>
                @if($project->role)
                    <div class="fade-up reveal-delay-2 mt-5 flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-primary/20 px-4 py-1.5 text-[10px] uppercase tracking-[0.2em] text-soft ring-1 ring-primary/30">
                            {{ $project->role }}
                        </span>
                    </div>
                @endif
                <div class="fade-up reveal-delay-2 editorial-rule mt-7 max-w-[7rem] bg-primary"></div>
            </div>
        </div>
    </section>

    {{-- Meta strip --}}
    <section class="border-b border-ink/8 bg-porcelain">
        <div class="mx-auto flex max-w-[90rem] flex-wrap items-center gap-x-8 gap-y-3 px-5 py-5 text-[10px] uppercase tracking-[0.22em] text-mist lg:px-10">
            <span class="text-primary">Studio study</span>
            @if($project->client)
                <span>{{ $project->client }}</span>
            @endif
            @if($project->year)
                <span>{{ $project->year }}</span>
            @endif
            @if($project->role)
                <span>{{ $project->role }}</span>
            @endif
            @if($gallery->isNotEmpty())
                <span class="ml-auto text-primary">{{ $gallery->count() }} frames</span>
            @endif
        </div>
    </section>

    {{-- Cover portrait --}}
    @if($project->coverUrl())
        <section class="relative overflow-hidden bg-soft/30 px-5 py-14 lg:px-10 lg:py-16">
            <div class="glow-orb pointer-events-none absolute -left-16 top-1/4 h-56 w-56 opacity-25"></div>
            <div class="glow-orb-sky pointer-events-none absolute -right-10 bottom-10 h-44 w-44 opacity-20"></div>

            <div class="reveal relative mx-auto grid max-w-5xl items-center gap-8 lg:grid-cols-12 lg:gap-12">
                <div class="relative mx-auto w-full max-w-sm lg:col-span-5 lg:mx-0">
                    <div class="pointer-events-none absolute -inset-3 rounded-[26px] border border-primary/25" aria-hidden="true"></div>
                    <div class="img-card relative aspect-[3/4] overflow-hidden rounded-[22px] shadow-[0_28px_56px_-16px_rgba(254,112,163,0.5)]">
                        <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-transparent to-transparent"></div>
                        <div class="absolute inset-x-0 bottom-0 p-5">
                            <p class="text-[10px] uppercase tracking-[0.24em] text-primary">Cover</p>
                            <p class="mt-1 font-serif text-xl italic text-porcelain">{{ $project->title }}</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="ornament mb-6 justify-start">
                        <span class="ornament-mark text-primary">✦</span>
                    </div>
                    <p class="section-label text-primary">Atelier note</p>
                    <h2 class="mt-3 font-serif text-3xl italic text-ink md:text-4xl">Form under light</h2>
                    @if(!empty($bodyParas[0]))
                        <p class="mt-6 font-serif text-lg leading-relaxed text-ink/65 md:text-xl">
                            {{ $bodyParas[0] }}
                        </p>
                    @elseif($project->excerpt)
                        <p class="mt-6 font-serif text-lg leading-relaxed text-ink/65 md:text-xl">
                            {{ $project->excerpt }}
                        </p>
                    @endif
                    <div class="mt-8 flex flex-wrap gap-3">
                        @foreach(array_filter([$project->client, $project->year, $project->role]) as $chip)
                            <span class="rounded-full border border-primary/25 bg-porcelain px-4 py-2 text-[10px] uppercase tracking-[0.18em] text-ink shadow-[0_6px_16px_-8px_rgba(254,112,163,0.4)]">
                                {{ $chip }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Study notes --}}
    @if(count($bodyParas) > ($project->coverUrl() ? 1 : 0))
        <section class="relative overflow-hidden border-y border-primary/10 bg-porcelain">
            <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(ellipse at 50% 0%, rgba(254,112,163,0.1), transparent 50%);"></div>
            <div class="relative mx-auto max-w-3xl px-5 py-16 text-center lg:px-10 lg:py-20">
                <div class="fade-up ornament mb-6 justify-center">
                    <span class="ornament-mark text-primary">❧</span>
                </div>
                <p class="fade-up section-label justify-center text-primary">Study notes</p>
                <div class="fade-up reveal-delay-1 mx-auto mt-8 max-w-2xl space-y-5 text-left font-serif text-lg leading-relaxed text-ink/65 md:text-xl">
                    @foreach(array_slice($bodyParas, $project->coverUrl() ? 1 : 0) as $para)
                        <p>{{ $para }}</p>
                    @endforeach
                </div>
            </div>
        </section>
    @elseif(!empty($bodyParas) && ! $project->coverUrl())
        <section class="relative overflow-hidden border-y border-primary/10 bg-porcelain">
            <div class="relative mx-auto max-w-3xl px-5 py-16 lg:px-10 lg:py-20">
                <div class="fade-up ornament mb-6 justify-center">
                    <span class="ornament-mark text-primary">✦</span>
                </div>
                <p class="fade-up section-label justify-center text-primary">Study notes</p>
                <div class="fade-up reveal-delay-1 mt-8 space-y-5 font-serif text-lg leading-relaxed text-ink/65 md:text-xl">
                    @foreach($bodyParas as $para)
                        <p>{{ $para }}</p>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery --}}
    @if($gallery->isNotEmpty())
        <section class="relative overflow-hidden bg-ink py-16 text-porcelain lg:py-20">
            <div class="hero-sparks opacity-25" aria-hidden="true"></div>
            <div class="glow-orb pointer-events-none absolute left-1/2 top-0 h-48 w-48 -translate-x-1/2 opacity-25"></div>

            <div class="relative mx-auto max-w-5xl px-5 lg:px-10">
                <div class="fade-up mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <div class="ornament mb-4 justify-start">
                            <span class="ornament-mark text-primary">✦</span>
                        </div>
                        <p class="text-[10px] uppercase tracking-[0.28em] text-primary">Gallery</p>
                        <h2 class="mt-3 font-display text-4xl italic md:text-5xl">Frames</h2>
                        <p class="mt-3 max-w-md font-serif text-base text-porcelain/55">Stills from the fitting room and campaign light.</p>
                    </div>
                    <p class="rounded-full border border-primary/30 bg-primary/15 px-4 py-1.5 text-[10px] uppercase tracking-[0.2em] text-primary">
                        {{ $gallery->count() }} frames
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4">
                    @foreach($gallery as $index => $image)
                        @php
                            $url = str_starts_with($image, 'http') ? $image : asset('storage/'.$image);
                        @endphp
                        <figure class="reveal group relative aspect-[3/4] max-h-72 overflow-hidden rounded-[18px] shadow-[0_16px_36px_-12px_rgba(254,112,163,0.45)] ring-1 ring-primary/20 transition duration-500 hover:-translate-y-1 hover:ring-primary/50 {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                            <img
                                src="{{ $url }}"
                                alt="{{ $project->title }} — {{ $index + 1 }}"
                                class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-ink/85 via-ink/10 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-3 md:p-4">
                                <p class="font-display text-2xl italic text-primary">
                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                </p>
                                <p class="mt-1 font-serif text-sm italic text-porcelain">{{ $project->title }}</p>
                                <p class="mt-1 text-[9px] uppercase tracking-[0.2em] text-porcelain/55">Frame {{ $index + 1 }}</p>
                            </div>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="relative overflow-hidden border-t border-porcelain/10 bg-porcelain">
        <div class="pointer-events-none absolute inset-0 opacity-60" style="background-image: radial-gradient(ellipse at 30% 0%, rgba(254,112,163,0.14), transparent 50%);"></div>
        <div class="relative mx-auto flex max-w-[90rem] flex-col gap-8 px-5 py-16 md:flex-row md:items-center md:justify-between lg:px-10 lg:py-20">
            <div>
                <div class="ornament mb-5 justify-start">
                    <span class="ornament-mark text-primary">✦</span>
                </div>
                <p class="font-display text-3xl italic text-ink md:text-4xl">Continue the conversation.</p>
                <p class="mt-3 font-serif text-lg text-ink/55">Fittings, campaigns, private capsules.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('contact') }}" class="btn-rose">Get in touch</a>
                <a href="{{ route('portfolio.index') }}" class="btn-ghost">All studies</a>
            </div>
        </div>
    </section>
@endsection
