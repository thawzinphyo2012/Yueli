@extends('layouts.storefront')

@section('title', 'Lookbook — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="relative overflow-hidden border-b border-ink/8 bg-blush/50">
        <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-rose/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-10 bottom-0 h-48 w-48 rounded-full bg-plum/5 blur-3xl"></div>
        <div class="relative mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-28">
            <div class="fade-up ornament mb-8 justify-start">
                <span class="ornament-mark">✦</span>
            </div>
            <p class="fade-up section-label">Fashion journal</p>
            <h1 class="fade-up reveal-delay-1 mt-4 font-serif text-4xl italic text-ink sm:text-5xl md:text-7xl">Lookbook</h1>
            <p class="fade-up reveal-delay-2 mt-6 max-w-xl font-serif text-xl leading-relaxed text-ink/60">
                Campaign photography and editorials — the magazine pages of the house. Cloth, light, and quiet form told frame by frame.
            </p>
            <div class="fade-up reveal-delay-3 mt-10 flex flex-wrap gap-6 text-[10px] uppercase tracking-[0.24em] text-mist">
                <span>{{ $campaigns->count() }} campaigns</span>
                <span class="text-rose">✦</span>
                <span>{{ $editorials->count() }} editorials</span>
            </div>
        </div>
    </section>

    <div class="marquee-strip" aria-hidden="true">
        <div class="marquee-track">
            @foreach(range(1, 2) as $_)
                <span>Lookbook</span><span>✦</span>
                <span>Campaign</span><span>✦</span>
                <span>Editorial</span><span>✦</span>
                <span>Photography</span><span>✦</span>
                <span>Yueli Studio</span><span>✦</span>
            @endforeach
        </div>
    </div>

    @if($campaigns->isNotEmpty())
        <section class="section-shell mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-28">
            <div class="fade-up mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="section-label">Campaigns</p>
                    <h2 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">Season narratives</h2>
                    <p class="mt-4 max-w-lg font-serif text-lg text-ink/55">
                        Full stories for each collection — light, place, and silhouette held still.
                    </p>
                </div>
            </div>

            <div class="grid gap-7 lg:grid-cols-2">
                @foreach($campaigns as $index => $lookbook)
                    <a href="{{ route('lookbook.show', $lookbook) }}" class="reveal lift-card group block {{ $index === 1 ? 'reveal-delay-1' : '' }}">
                        <div class="media-frame img-card relative aspect-[16/10] rounded-[24px]">
                            @if($lookbook->coverUrl())
                                <img src="{{ $lookbook->coverUrl() }}" alt="{{ $lookbook->title }}" class="img-editorial">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-ink/20">
                                    <i data-lucide="aperture" class="h-10 w-10"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 z-[1] bg-gradient-to-t from-ink/85 via-ink/25 to-transparent"></div>
                            <div class="absolute left-4 top-4 z-[2] rounded-full bg-porcelain/95 px-3 py-1 text-[9px] font-semibold uppercase tracking-[0.18em] text-ink shadow-sm">
                                Campaign
                            </div>
                            <div class="absolute inset-x-0 bottom-0 z-[2] p-6 md:p-8">
                                <h3 class="font-serif text-3xl italic text-porcelain md:text-4xl">{{ $lookbook->title }}</h3>
                                @if($lookbook->description)
                                    <p class="mt-3 max-w-md text-sm leading-relaxed text-porcelain/70">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($lookbook->description), 110) }}
                                    </p>
                                @endif
                                @if($lookbook->photographer || $lookbook->location)
                                    <p class="mt-4 text-[10px] uppercase tracking-[0.22em] text-rose">
                                        {{ collect([$lookbook->photographer, $lookbook->location])->filter()->implode(' · ') }}
                                    </p>
                                @endif
                                <span class="mt-5 inline-flex items-center gap-2 text-[10px] uppercase tracking-[0.22em] text-porcelain/80 transition group-hover:text-rose">
                                    Open story
                                    <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if($editorials->isNotEmpty())
        <section class="relative border-t border-ink/8 bg-blush/40">
            <div class="pointer-events-none absolute inset-0 opacity-50" style="background-image: radial-gradient(ellipse at 80% 10%, rgba(254,112,163,0.15), transparent 40%);"></div>
            <div class="relative mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-28">
                <div class="fade-up ornament mb-10">
                    <span class="ornament-mark">✦</span>
                </div>
                <div class="fade-up mb-12 text-center">
                    <p class="section-label justify-center">Editorials</p>
                    <h2 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">Studies in form</h2>
                    <p class="mx-auto mt-4 max-w-lg font-serif text-lg text-ink/55">
                        Smaller chapters — texture, fitting, and the quiet between campaigns.
                    </p>
                </div>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($editorials as $index => $lookbook)
                        <a href="{{ route('lookbook.show', $lookbook) }}" class="reveal product-box group {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                            <div class="product-box-media media-frame aspect-[3/4]">
                                <span class="product-box-tag">Editorial</span>
                                @if($lookbook->coverUrl())
                                    <img src="{{ $lookbook->coverUrl() }}" alt="{{ $lookbook->title }}" class="img-editorial">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-ink/20">
                                        <i data-lucide="image" class="h-10 w-10"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="product-box-body">
                                <h3 class="font-serif text-2xl italic text-ink transition group-hover:text-rose">{{ $lookbook->title }}</h3>
                                @if($lookbook->photographer || $lookbook->location)
                                    <p class="text-[10px] uppercase tracking-[0.2em] text-mist">
                                        {{ collect([$lookbook->photographer, $lookbook->location])->filter()->implode(' · ') }}
                                    </p>
                                @endif
                                @if($lookbook->description)
                                    <p class="text-sm leading-relaxed text-mist">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($lookbook->description), 95) }}
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($campaigns->isEmpty() && $editorials->isEmpty())
        <div class="mx-auto max-w-7xl px-5 py-24 text-center lg:px-8">
            <p class="fade-up section-label justify-center">Lookbook</p>
            <h2 class="fade-up reveal-delay-1 mt-4 font-serif text-3xl italic text-ink">Stories forthcoming</h2>
            <a href="{{ route('shop.index') }}" class="btn-ghost mt-8">Shop the collection</a>
        </div>
    @endif
@endsection
