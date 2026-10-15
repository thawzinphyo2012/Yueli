@extends('layouts.storefront')

@section('title', $lookbook->title.' — '.($siteName ?? 'Yueli Studio'))

@section('content')
    @php
        $gallery = collect($lookbook->images ?? [])->filter()->values();
    @endphp

    <section class="grain relative min-h-[75vh] overflow-hidden bg-ink text-porcelain">
        @if($lookbook->coverUrl())
            <img src="{{ $lookbook->coverUrl() }}" alt="" class="ken-burns absolute inset-0 h-full w-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-r from-ink/90 via-ink/55 to-ink/25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink/85 via-transparent to-ink/35"></div>
        @endif
        <div class="hero-sparks opacity-60" aria-hidden="true"></div>
        <div class="glow-orb right-[12%] top-1/3 h-64 w-64 opacity-45"></div>

        <div class="relative z-10 mx-auto flex min-h-[75vh] max-w-[90rem] flex-col justify-end px-5 pb-16 pt-28 lg:px-10 lg:pb-24">
            <a href="{{ route('lookbook.index') }}" class="fade-up inline-flex min-h-11 items-center gap-2 text-[10px] uppercase tracking-[0.24em] text-porcelain/55 transition hover:text-rose">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                Lookbook
            </a>

            <p class="fade-up reveal-delay-1 mt-8 inline-flex items-center gap-3 text-[11px] uppercase tracking-[0.28em]">
                <span class="rounded-full bg-rose/90 px-3 py-1 text-[9px] font-semibold text-porcelain">
                    {{ $lookbook->is_campaign ? 'Campaign' : 'Editorial' }}
                </span>
                @if($lookbook->collection)
                    <a href="{{ route('collections.show', $lookbook->collection) }}" class="text-porcelain/70 transition hover:text-rose">
                        {{ $lookbook->collection->name }}
                    </a>
                @endif
            </p>

            <h1 class="fade-up reveal-delay-2 mt-5 max-w-3xl font-serif text-5xl italic leading-tight md:text-6xl lg:text-7xl">
                {{ $lookbook->title }}
            </h1>

            @if($lookbook->photographer || $lookbook->location)
                <p class="fade-up reveal-delay-3 mt-5 text-[11px] uppercase tracking-[0.24em] text-rose">
                    {{ collect([
                        $lookbook->photographer ? 'Photo · '.$lookbook->photographer : null,
                        $lookbook->location,
                    ])->filter()->implode(' · ') }}
                </p>
            @endif

            @if($gallery->isNotEmpty())
                <p class="fade-up reveal-delay-4 mt-6 text-[10px] uppercase tracking-[0.22em] text-porcelain/45">
                    {{ $gallery->count() }} frames
                </p>
            @endif
        </div>
    </section>

    @if($lookbook->description)
        <section class="section-shell border-b border-ink/8 bg-blush/40">
            <div class="mx-auto max-w-3xl px-5 py-20 text-center lg:px-10 lg:py-24">
                <div class="fade-up ornament mb-8">
                    <span class="ornament-mark">✦</span>
                </div>
                <p class="fade-up section-label justify-center">Story</p>
                <div class="quote-frame fade-up reveal-delay-1 mt-8 space-y-5 text-left font-serif text-xl leading-relaxed text-ink/75 md:text-2xl">
                    {!! nl2br(e($lookbook->description)) !!}
                </div>
                <div class="fade-up reveal-delay-2 ornament mt-12">
                    <span class="ornament-mark text-lg">❧</span>
                </div>
            </div>
        </section>
    @endif

    @if($gallery->isNotEmpty())
        <section class="mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-28">
            <div class="fade-up mb-12 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="section-label">Gallery</p>
                    <h2 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">Selected frames</h2>
                </div>
                <p class="text-[10px] uppercase tracking-[0.24em] text-mist">{{ $gallery->count() }} images</p>
            </div>

            {{-- Featured lead image --}}
            @php $lead = $gallery->first(); @endphp
            <figure class="reveal mb-8 overflow-hidden rounded-[24px] shadow-[0_22px_48px_-16px_rgba(254,112,163,0.45)]">
                <img
                    src="{{ str_starts_with($lead, 'http') ? $lead : asset('storage/'.$lead) }}"
                    alt="{{ $lookbook->title }} — cover frame"
                    class="aspect-[21/9] w-full object-cover md:aspect-[21/8]"
                >
            </figure>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($gallery->skip(1) as $index => $image)
                    @php
                        $url = str_starts_with($image, 'http') ? $image : asset('storage/'.$image);
                        $tall = $index % 5 === 1 || $index % 5 === 3;
                    @endphp
                    <figure class="reveal lift-card group overflow-hidden rounded-[22px] bg-blush shadow-[0_14px_34px_-14px_rgba(254,112,163,0.4)] {{ $tall ? 'sm:row-span-1' : '' }} {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                        <div class="media-frame {{ $tall ? 'aspect-[3/4]' : 'aspect-[4/5]' }}">
                            <img src="{{ $url }}" alt="{{ $lookbook->title }} — {{ $index + 2 }}" class="img-editorial">
                        </div>
                        <figcaption class="px-4 py-3 text-[10px] uppercase tracking-[0.2em] text-mist">
                            Frame {{ str_pad((string) ($index + 2), 2, '0', STR_PAD_LEFT) }}
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @elseif(!$lookbook->description)
        <div class="mx-auto max-w-7xl px-5 py-20 text-center lg:px-8">
            <p class="font-serif text-xl italic text-ink/50">Gallery images coming soon.</p>
        </div>
    @endif

    <section class="border-t border-ink/8 bg-ink text-porcelain">
        <div class="mx-auto flex max-w-[90rem] flex-col items-start justify-between gap-6 px-5 py-14 sm:flex-row sm:items-center lg:px-10">
            <div>
                <p class="section-label text-rose">Continue</p>
                <p class="mt-3 font-serif text-2xl italic">More from the journal</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('lookbook.index') }}" class="btn-outline border-porcelain/30">All lookbooks</a>
                <a href="{{ route('shop.index') }}" class="btn-rose">Shop the edit</a>
            </div>
        </div>
    </section>
@endsection
