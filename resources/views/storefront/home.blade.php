@extends('layouts.storefront')

@section('title', ($siteName ?? 'Yueli Studio').' — Editorial Fashion')

@section('content')
    @php
        $heroTitle = $hero->title ?? 'Soft structure, quiet presence.';
        $heroSubtitle = $hero->subtitle ?? 'Season 26';
        $heroBody = $hero->body ?? ($siteTagline ?? 'Clothing composed like a magazine spread — feminine, minimal, enduring.');
        $heroCtaLabel = $hero->cta_label ?? 'Enter the edit';
        $heroCtaUrl = $hero->cta_url ?? route('shop.index');
        $heroImage = null;
        if ($hero?->image) {
            $heroImage = str_starts_with($hero->image, 'http') ? $hero->image : asset('storage/'.$hero->image);
        }
    @endphp

    {{-- Cover — Harvest-style cinematic hero --}}
    <section class="grain relative min-h-[100svh] w-full overflow-hidden bg-ink text-porcelain">
        @if($heroImage)
            <img src="{{ $heroImage }}" alt="" class="ken-burns absolute inset-0 h-full w-full scale-105 object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-ink/90 via-ink/55 to-ink/20"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-transparent to-ink/30"></div>
        @else
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_70%_20%,#FE70A3_0%,transparent_50%),linear-gradient(165deg,#000002_0%,#E90E1E_100%)]"></div>
        @endif

        <div class="hero-sparks" aria-hidden="true"></div>
        <div class="deco-dots" aria-hidden="true"></div>
        <div class="glow-orb -right-8 top-1/3 h-72 w-72 opacity-50"></div>
        <div class="glow-orb-sky bottom-1/4 left-[6%] h-52 w-52 opacity-45" style="animation-delay: 1.2s"></div>
        <div class="glow-orb-sky right-[18%] bottom-[12%] h-36 w-36 opacity-35" style="animation-delay: 2s"></div>

        <div class="relative z-10 mx-auto flex min-h-[100svh] max-w-[90rem] items-center px-4 py-24 sm:px-5 sm:py-28 lg:px-10">
            <div class="max-w-2xl">
                <p class="fade-up text-[10px] font-medium uppercase tracking-[0.28em] sm:text-[11px]">
                    <span class="text-rose">{{ $heroSubtitle ?? 'Season 26' }}</span>
                    <span class="text-porcelain/50"> · </span>
                    <span class="text-sky/90">Contemporary Atelier</span>
                </p>

                <p class="fade-up reveal-delay-1 mt-5 font-display text-4xl font-medium italic leading-none tracking-[0.02em] text-porcelain sm:mt-7 sm:text-6xl md:text-7xl lg:text-8xl">
                    {{ $siteName ?? 'Yueli Studio' }}
                </p>

                <h1 class="fade-up reveal-delay-2 mt-6 max-w-xl font-serif text-[1.75rem] font-normal leading-[1.15] text-porcelain sm:mt-8 sm:text-4xl md:text-5xl lg:text-[3.25rem]">
                    Cloth for a
                    <em class="hero-accent">quiet</em>
                    silhouette.
                </h1>

                <p class="fade-up reveal-delay-3 mt-5 max-w-md font-serif text-base leading-relaxed text-porcelain/70 sm:mt-6 sm:text-lg md:text-xl">
                    {{ $heroBody }}
                </p>

                <div class="fade-up reveal-delay-4 mt-8 flex flex-col gap-3 sm:mt-10 sm:flex-row sm:flex-wrap sm:items-center sm:gap-4">
                    <a href="{{ $heroCtaUrl }}" class="btn-rose w-full sm:w-auto">{{ $heroCtaLabel }}</a>
                    <a href="{{ route('lookbook.index') }}" class="btn-outline w-full sm:w-auto">Read the lookbook</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Marquee ribbon --}}
    <div class="marquee-strip" aria-hidden="true">
        <div class="marquee-track">
            @foreach(range(1, 2) as $loopPass)
                <span>Yueli Studio</span><span>✦</span>
                <span>Soft Structure</span><span>✦</span>
                <span>Lookbook</span><span>✦</span>
                <span>The Edit</span><span>✦</span>
                <span>Quiet Luxury</span><span>✦</span>
                <span>Contemporary Atelier</span><span>✦</span>
            @endforeach
        </div>
    </div>

    {{-- Manifesto --}}
    <section class="section-shell relative border-b border-ink/8 bg-blush/50">
        <div class="glow-orb-sky pointer-events-none absolute left-1/2 top-8 h-40 w-40 -translate-x-1/2 opacity-25"></div>
        <div class="relative mx-auto max-w-3xl px-4 py-16 text-center sm:px-5 sm:py-24 lg:px-10 lg:py-32">
            <div class="fade-up ornament mb-8">
                <span class="ornament-mark text-sky">✦</span>
            </div>
            <p class="fade-up section-label justify-center">Manifesto</p>
            <blockquote class="quote-frame panel-soft fade-up reveal-delay-1 mx-auto mt-6 px-5 py-8 font-serif text-2xl italic leading-snug text-ink sm:mt-8 sm:px-8 sm:py-10 sm:text-3xl md:px-12 md:text-4xl lg:text-5xl">
                Not a catalogue — a journal of cloth, light, and feminine form.
            </blockquote>
            <div class="fade-up reveal-delay-2 ornament mt-12">
                <span class="ornament-mark text-lg text-sky">❧</span>
            </div>
        </div>
    </section>

    {{-- Campaign story --}}
    @if($campaign)
        @php $campaignCover = $campaign->coverUrl(); @endphp
        <section class="relative min-h-[85vh] overflow-hidden bg-plum text-porcelain">
            @if($campaignCover)
                <img src="{{ $campaignCover }}" alt="{{ $campaign->title }}" class="absolute inset-0 h-full w-full object-cover opacity-75">
                <div class="absolute inset-0 bg-gradient-to-r from-ink/90 via-ink/40 to-transparent"></div>
            @endif
            <div class="hero-sparks opacity-50" aria-hidden="true"></div>
            <div class="glow-orb right-[10%] top-[20%] h-56 w-56 opacity-40"></div>
            <div class="relative z-10 mx-auto grid min-h-[85vh] max-w-[90rem] items-end gap-10 px-5 py-20 lg:grid-cols-12 lg:px-10">
                <div class="fade-up lg:col-span-6">
                    <p class="section-label text-rose">Campaign story</p>
                    <h2 class="mt-5 font-serif text-5xl italic leading-tight md:text-6xl">{{ $campaign->title }}</h2>
                    @if($campaign->description)
                        <p class="mt-6 max-w-md font-serif text-lg leading-relaxed text-porcelain/70">
                            {{ \Illuminate\Support\Str::limit(strip_tags($campaign->description), 180) }}
                        </p>
                    @endif
                    <a href="{{ route('lookbook.show', $campaign) }}" class="btn-outline mt-10">Open campaign</a>
                </div>
                <div class="fade-up reveal-delay-2 hidden self-center lg:col-span-5 lg:col-start-8 lg:block">
                    <div class="rounded-[28px] border border-soft/25 bg-porcelain/10 p-8 shadow-[0_28px_56px_-18px_rgba(254,112,163,0.45)] backdrop-blur-md">
                        <p class="font-serif text-8xl italic text-sky/30">01</p>
                        <div class="editorial-rule mt-4 bg-sky"></div>
                        <p class="mt-6 text-[10px] uppercase tracking-[0.28em] text-porcelain/55">
                            {{ collect([$campaign->photographer, $campaign->location])->filter()->implode(' · ') ?: 'Editorial photography' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Collection spreads --}}
    @if($collections->isNotEmpty())
        <section class="section-shell mx-auto max-w-[90rem] px-5 py-24 lg:px-10 lg:py-32">
            <div class="fade-up ornament mb-10">
                <span class="ornament-mark text-sky">✦</span>
            </div>
            <div class="fade-up mb-16 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="section-label">Chapters</p>
                    <h2 class="mt-4 font-serif text-5xl italic text-ink md:text-6xl">Collections</h2>
                </div>
                <a href="{{ route('collections.index') }}" class="text-[10px] uppercase tracking-[0.24em] text-mist transition hover:text-sky">
                    All seasons →
                </a>
            </div>

            <div class="mx-auto grid max-w-5xl gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6">
                @foreach($collections as $index => $collection)
                    @php
                        $cover = $collection->cover_image
                            ? (str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/'.$collection->cover_image))
                            : null;
                    @endphp
                    <a href="{{ route('collections.show', $collection) }}" class="reveal lift-card group relative block {{ $index === 1 ? 'reveal-delay-1' : ($index === 2 ? 'reveal-delay-2' : '') }}">
                        <div class="media-frame img-card aspect-[3/4]">
                            @if($cover)
                                <img src="{{ $cover }}" alt="{{ $collection->name }}" class="img-editorial">
                            @endif
                            <div class="absolute inset-0 z-[1] bg-gradient-to-t from-ink/75 via-ink/10 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 z-[2] p-5 md:p-6">
                                @if($collection->season)
                                    <p class="text-[10px] uppercase tracking-[0.28em] text-rose">{{ $collection->season }}</p>
                                @endif
                                <h3 class="mt-2 font-serif text-2xl italic text-porcelain md:text-3xl">{{ $collection->name }}</h3>
                            </div>
                        </div>
                        @if($collection->description)
                            <div class="mt-4 space-y-2 px-1">
                                <p class="font-serif text-base leading-relaxed text-ink/65">
                                    {{ \Illuminate\Support\Str::limit(preg_replace("/\s+/", ' ', $collection->description), 120) }}
                                </p>
                                <span class="inline-block text-[10px] uppercase tracking-[0.22em] text-rose opacity-0 transition group-hover:opacity-100">
                                    Enter chapter →
                                </span>
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- The Edit --}}
    @if($products->isNotEmpty())
        <section class="relative overflow-hidden border-y border-ink/8 bg-blush/60">
            <div class="pointer-events-none absolute inset-0 opacity-50" style="background-image: radial-gradient(ellipse at 20% 0%, rgba(254,112,163,0.16), transparent 45%), radial-gradient(ellipse at 90% 100%, rgba(247,162,197,0.2), transparent 40%);"></div>
            <div class="glow-orb-sky pointer-events-none absolute -right-16 top-24 h-64 w-64 opacity-20"></div>
            <div class="relative mx-auto max-w-[90rem] px-5 py-24 lg:px-10 lg:py-28">
                <div class="fade-up ornament mb-10">
                    <span class="ornament-mark text-sky">✦</span>
                </div>
                <div class="fade-up mb-6 flex flex-col gap-6 lg:mb-14 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-xl">
                        <p class="section-label">Boutique</p>
                        <h2 class="mt-4 font-serif text-5xl italic text-ink md:text-6xl">The Edit</h2>
                        <p class="mt-5 font-serif text-xl leading-relaxed text-ink/60">
                            Shop the pieces from the pages — easy to choose, quiet to wear.
                        </p>
                    </div>
                    <a href="{{ route('shop.index') }}" class="btn-ghost shrink-0">Shop all pieces</a>
                </div>

                <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($products as $index => $product)
                        <a href="{{ route('shop.show', $product) }}" class="reveal product-box group {{ 'reveal-delay-'.(($index % 4) + 1) }}">
                            <div class="product-box-media media-frame aspect-[3/4]">
                                @if($product->is_featured)
                                    <span class="product-box-tag">Featured</span>
                                @endif
                                @if($product->imageUrl())
                                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="img-editorial">
                                @endif
                            </div>
                            <div class="product-box-body">
                                @if($product->collection)
                                    <p class="text-[10px] uppercase tracking-[0.22em] text-mist">{{ $product->collection->name }}</p>
                                @endif
                                <div class="product-box-meta">
                                    <h3 class="font-serif text-2xl italic leading-tight text-ink transition group-hover:text-rose">{{ $product->name }}</h3>
                                    <p class="shrink-0 pt-1 text-[12px] tracking-[0.08em] text-ink">${{ number_format($product->price, 2) }}</p>
                                </div>
                                @if($product->short_description)
                                    <p class="text-sm leading-relaxed text-mist">{{ \Illuminate\Support\Str::limit($product->short_description, 56) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Studio — cinematic dossier --}}
    @if($projects->isNotEmpty())
        @php
            $featuredStudio = $projects->first();
            $studioParas = $studioIntro?->body
                ? preg_split("/\n\s*\n/", trim($studioIntro->body))
                : ['Process, fittings, and collaborations — the artistic side of the house.'];
            $filmFrames = $projects
                ->flatMap(function ($p) {
                    return collect([$p->cover_image])
                        ->merge($p->gallery ?? [])
                        ->filter();
                })
                ->unique()
                ->take(8)
                ->values();
        @endphp

        {{-- Quote ribbon --}}
        <section class="relative overflow-hidden border-y border-primary/15 bg-soft/30">
            <div class="glow-orb pointer-events-none absolute -left-16 top-1/2 h-40 w-40 -translate-y-1/2 opacity-30"></div>
            <div class="relative mx-auto max-w-3xl px-5 py-14 text-center lg:px-10 lg:py-16">
                <p class="fade-up ornament justify-center">
                    <span class="ornament-mark text-primary">❧</span>
                </p>
                <blockquote class="fade-up reveal-delay-1 mt-6 font-serif text-2xl italic leading-snug text-ink md:text-3xl lg:text-4xl">
                    Cloth, light, and the quiet discipline of form.
                </blockquote>
                <p class="fade-up reveal-delay-2 mt-5 text-[10px] uppercase tracking-[0.28em] text-mist">Yueli Studio · Process</p>
            </div>
        </section>

        {{-- Index strip — magazine TOC --}}
        <section class="relative overflow-hidden border-b border-ink/8 bg-porcelain">
            <div class="pointer-events-none absolute inset-0 opacity-40" style="background-image: radial-gradient(ellipse at 10% 0%, rgba(254,112,163,0.1), transparent 45%), radial-gradient(ellipse at 90% 100%, rgba(247,162,197,0.12), transparent 40%);"></div>
            <div class="relative mx-auto max-w-[90rem] px-5 py-14 lg:px-10 lg:py-16">
                <div class="fade-up ornament mb-8">
                    <span class="ornament-mark text-primary">✦</span>
                </div>
                <div class="fade-up flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="section-label">Selected studies</p>
                        <h3 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">The dossier</h3>
                    </div>
                    <p class="font-serif text-sm italic text-mist">{{ $projects->count() }} chapters in the house archive</p>
                </div>
                <ol class="mt-10 space-y-3">
                    @foreach($projects as $index => $project)
                        <li class="reveal {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                            <a href="{{ route('portfolio.show', $project) }}" class="group panel-soft flex items-center gap-5 px-4 py-4 transition hover:-translate-y-0.5 md:gap-8 md:px-6 md:py-5">
                                <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary/15 font-display text-2xl italic text-primary transition group-hover:bg-primary group-hover:text-white md:h-14 md:w-14 md:text-3xl">
                                    {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                                </span>
                                @if($project->coverUrl())
                                    <span class="hidden h-16 w-12 shrink-0 overflow-hidden rounded-[12px] shadow-[0_10px_24px_-10px_rgba(254,112,163,0.45)] sm:block md:h-20 md:w-14">
                                        <img src="{{ $project->coverUrl() }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    </span>
                                @endif
                                <span class="min-w-0 flex-1">
                                    <span class="block font-serif text-2xl italic text-ink transition group-hover:text-primary md:text-3xl">{{ $project->title }}</span>
                                    <span class="mt-1 block text-[10px] uppercase tracking-[0.22em] text-mist">
                                        {{ collect([$project->role, $project->year])->filter()->implode(' · ') }}
                                    </span>
                                </span>
                                <span class="hidden shrink-0 rounded-full border border-primary/25 px-4 py-2 text-[10px] uppercase tracking-[0.2em] text-primary transition group-hover:border-primary group-hover:bg-primary group-hover:text-white md:inline">
                                    Open →
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        {{-- Horizontal film reel --}}
        @if($filmFrames->isNotEmpty())
            <section class="relative overflow-hidden bg-ink py-16 text-porcelain lg:py-20">
                <div class="hero-sparks opacity-30" aria-hidden="true"></div>
                <div class="glow-orb pointer-events-none absolute left-1/2 top-0 h-56 w-56 -translate-x-1/2 opacity-25"></div>
                <div class="relative mx-auto mb-10 flex max-w-[90rem] flex-col gap-4 px-5 sm:flex-row sm:items-end sm:justify-between lg:px-10">
                    <div>
                        <div class="ornament mb-4 justify-start">
                            <span class="ornament-mark text-primary">✦</span>
                        </div>
                        <p class="text-[10px] uppercase tracking-[0.28em] text-primary">Atelier reel</p>
                        <h3 class="mt-3 font-serif text-3xl italic md:text-4xl lg:text-5xl">Frames from the studies</h3>
                        <p class="mt-3 max-w-md font-serif text-base text-porcelain/55">A moving strip of fittings, stills, and campaign light.</p>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-soft">Scroll →</p>
                </div>
                <div class="studio-reel relative flex gap-4 overflow-x-auto px-5 pb-6 lg:gap-5 lg:px-10" style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;">
                    @foreach($filmFrames as $index => $image)
                        @php
                            $url = str_starts_with($image, 'http') ? $image : asset('storage/'.$image);
                        @endphp
                        <figure class="group relative h-72 w-[70vw] shrink-0 overflow-hidden rounded-[20px] shadow-[0_20px_48px_-16px_rgba(254,112,163,0.5)] ring-1 ring-primary/20 sm:h-80 sm:w-[42vw] md:w-[28vw] lg:h-[22rem] lg:w-[22vw]" style="scroll-snap-align: start;">
                            <img src="{{ $url }}" alt="Studio frame {{ $index + 1 }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]">
                            <div class="absolute inset-0 bg-gradient-to-t from-ink/70 via-transparent to-transparent opacity-80"></div>
                            <span class="absolute bottom-4 left-4 font-display text-3xl italic text-primary">
                                {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <span class="absolute bottom-5 right-4 text-[9px] uppercase tracking-[0.22em] text-porcelain/60">Frame</span>
                        </figure>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Featured study deep dive --}}
        @php
            $deep = $projects->get(1) ?? $featuredStudio;
            $deepParas = $deep?->body ? preg_split("/\n\s*\n/", trim($deep->body)) : [];
            $deepSlides = collect([$deep?->cover_image])
                ->merge($deep->gallery ?? [])
                ->filter()
                ->unique()
                ->values()
                ->map(fn ($image) => str_starts_with($image, 'http') ? $image : asset('storage/'.$image))
                ->all();
        @endphp
        @if($deep && count($deepSlides))
            <section
                class="relative overflow-hidden bg-soft/25"
                x-data="{
                    slides: {{ Js::from($deepSlides) }},
                    active: 0,
                    timer: null,
                    next() { this.active = (this.active + 1) % this.slides.length },
                    go(i) { this.active = i },
                    start() {
                        this.stop();
                        if (this.slides.length < 2) return;
                        this.timer = setInterval(() => this.next(), 4000);
                    },
                    stop() { if (this.timer) { clearInterval(this.timer); this.timer = null } }
                }"
                x-init="start()"
            >
                <div class="glow-orb pointer-events-none absolute -right-20 top-24 h-64 w-64 opacity-25"></div>
                <div class="glow-orb-sky pointer-events-none absolute -left-16 bottom-20 h-52 w-52 opacity-20"></div>

                <div class="relative mx-auto max-w-[90rem] px-5 pt-14 lg:px-10 lg:pt-20">
                    <div class="fade-up ornament mb-8">
                        <span class="ornament-mark text-primary">✦</span>
                    </div>
                    <div class="fade-up mb-12 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="section-label text-primary">Spotlight study</p>
                            <h3 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">In the frame</h3>
                        </div>
                        <p class="font-serif text-sm italic text-mist">Auto-advancing editorial stills</p>
                    </div>
                </div>

                <div class="relative mx-auto grid max-w-[90rem] items-center gap-8 px-5 pb-10 lg:grid-cols-12 lg:gap-12 lg:px-10 lg:pb-14">
                    <div class="mx-auto w-full max-w-md lg:col-span-5 lg:mx-0 lg:max-w-lg">
                        <div class="relative">
                            <div class="pointer-events-none absolute -inset-3 rounded-[28px] border border-primary/20" aria-hidden="true"></div>
                            <div class="img-card relative aspect-[3/4] overflow-hidden rounded-[22px] shadow-[0_24px_50px_-16px_rgba(254,112,163,0.45)]">
                                <template x-for="(slide, index) in slides" :key="index">
                                    <img
                                        :src="slide"
                                        :alt="'{{ addslashes($deep->title) }} — ' + (index + 1)"
                                        class="pointer-events-none absolute inset-0 h-full w-full object-cover transition-opacity duration-700 ease-out"
                                        :class="active === index ? 'opacity-100' : 'opacity-0'"
                                        :aria-hidden="active !== index"
                                    >
                                </template>
                            </div>

                            @if(count($deepSlides) > 1)
                                <div class="mt-5 flex items-center justify-center gap-2" aria-hidden="true">
                                    <template x-for="(slide, index) in slides" :key="'dot-' + index">
                                        <span
                                            class="h-1.5 rounded-full transition-all duration-300"
                                            :class="active === index ? 'w-6 bg-primary' : 'w-1.5 bg-ink/15'"
                                        ></span>
                                    </template>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col justify-center lg:col-span-7 lg:pl-4">
                        <p class="text-[10px] uppercase tracking-[0.24em] text-primary">
                            {{ collect([$deep->client, $deep->year])->filter()->implode(' · ') }}
                        </p>
                        @if($deep->role)
                            <p class="mt-2 text-[10px] uppercase tracking-[0.2em] text-mist">{{ $deep->role }}</p>
                        @endif
                        <h3 class="mt-4 font-serif text-4xl italic text-ink md:text-5xl lg:text-6xl">{{ $deep->title }}</h3>
                        <div class="editorial-rule mt-5 max-w-[6rem] bg-primary"></div>
                        @if($deep->excerpt)
                            <p class="mt-6 max-w-xl font-serif text-lg leading-relaxed text-ink/65 md:text-xl">{{ $deep->excerpt }}</p>
                        @endif
                        @if(!empty($deepParas[0]))
                            <p class="mt-5 max-w-xl font-serif text-base leading-relaxed text-ink/55">{{ $deepParas[0] }}</p>
                        @endif
                        <a href="{{ route('portfolio.show', $deep) }}" class="btn-rose mt-10 w-fit">Read full study</a>
                    </div>
                </div>

                @if(count($deepSlides) > 1)
                    <div class="relative mx-auto grid max-w-5xl grid-cols-2 gap-3 px-5 pb-16 sm:grid-cols-4 sm:gap-4 lg:px-10 lg:pb-20">
                        <template x-for="(slide, index) in slides" :key="'thumb-' + index">
                            <button
                                type="button"
                                class="img-card group aspect-[3/4] overflow-hidden rounded-[18px] ring-offset-2 ring-offset-soft/25 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
                                :class="active === index ? 'ring-2 ring-primary' : 'ring-0 opacity-80 hover:opacity-100'"
                                @click="go(index)"
                                :aria-label="'Show image ' + (index + 1)"
                                :aria-pressed="active === index"
                            >
                                <img :src="slide" :alt="'{{ addslashes($deep->title) }} thumb ' + (index + 1)" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]">
                            </button>
                        </template>
                    </div>
                @endif
            </section>
        @endif

        {{-- Closing band --}}
        <section class="relative overflow-hidden border-b border-ink/8 bg-porcelain">
            <div class="pointer-events-none absolute inset-0 opacity-50" style="background-image: radial-gradient(ellipse at 50% 0%, rgba(254,112,163,0.12), transparent 50%);"></div>
            <div class="relative mx-auto flex max-w-[90rem] flex-col items-start justify-between gap-8 px-5 py-16 md:flex-row md:items-center lg:px-10 lg:py-20">
                <div class="max-w-lg">
                    <div class="ornament mb-6 justify-start">
                        <span class="ornament-mark text-primary">✦</span>
                    </div>
                    <p class="section-label text-primary">Collaborate</p>
                    <p class="mt-4 font-serif text-3xl italic leading-snug text-ink md:text-4xl">
                        Fittings, campaigns, private capsules.
                    </p>
                    @if(count($studioParas) > 1)
                        <p class="mt-4 font-serif text-lg leading-relaxed text-ink/55">{{ $studioParas[1] }}</p>
                    @endif
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="btn-rose">Start a conversation</a>
                    <a href="{{ route('portfolio.index') }}" class="btn-ghost">All studio work</a>
                </div>
            </div>
        </section>
    @endif

    {{-- Brand close --}}
    @if($about)
        @php
            $aboutImage = $about->image
                ? (str_starts_with($about->image, 'http') ? $about->image : asset('storage/'.$about->image))
                : null;
        @endphp
        <section class="relative overflow-hidden bg-ink text-porcelain">
            <div class="glow-orb-sky pointer-events-none absolute -left-20 bottom-0 h-72 w-72 opacity-25"></div>
            <div class="deco-dots opacity-40" aria-hidden="true"></div>
            <div class="relative mx-auto grid max-w-[90rem] items-center gap-10 px-5 py-16 lg:grid-cols-2 lg:gap-16 lg:px-10 lg:py-24">
                <div class="reveal order-1 mx-auto w-full max-w-sm sm:max-w-md lg:mx-0 lg:max-w-md">
                    <div class="corner-frame aspect-[3/4] overflow-hidden rounded-[22px] shadow-[0_28px_56px_-14px_rgba(254,112,163,0.5),0_10px_24px_-8px_rgba(247,162,197,0.35)]">
                        @if($aboutImage)
                            <img src="{{ $aboutImage }}" alt="" class="h-full w-full object-cover opacity-95">
                        @else
                            <div class="h-full min-h-[22rem] bg-gradient-to-br from-plum to-ink"></div>
                        @endif
                    </div>
                </div>
                <div class="fade-up order-2 flex flex-col justify-center py-4 lg:py-8">
                    <div class="ornament mb-8 justify-start">
                        <span class="ornament-mark text-sky">✦</span>
                    </div>
                    <p class="section-label text-rose">{{ $about->subtitle ?? 'The house' }}</p>
                    <h2 class="mt-5 font-serif text-5xl italic leading-tight md:text-6xl">
                        {{ $about->title ?? 'An atelier of quiet precision' }}
                    </h2>
                    @if($about->body)
                        <p class="mt-8 max-w-md font-serif text-xl leading-relaxed text-porcelain/65">
                            {{ \Illuminate\Support\Str::limit(strip_tags($about->body), 220) }}
                        </p>
                    @endif
                    <div class="mt-10 flex flex-wrap gap-4">
                        <a href="{{ $about->cta_url ?? route('about') }}" class="btn-rose">
                            {{ $about->cta_label ?? 'Our story' }}
                        </a>
                        <a href="{{ route('contact') }}" class="btn-outline">Contact</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
