@extends('layouts.storefront')

@section('title', 'About — '.($siteName ?? 'Yueli Studio'))

@section('content')
    @php
        $manifesto = $blocks->firstWhere('key', 'about_manifesto') ?? $blocks->first();
        $process = $blocks->firstWhere('key', 'about_process');

        $portraitA = $manifesto?->image
            ? (str_starts_with($manifesto->image, 'http') ? $manifesto->image : asset('storage/'.$manifesto->image))
            : 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?auto=format&fit=crop&w=1200&q=80';

        $portraitB = 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80';

        $pillars = [
            [
                'title' => 'The cloth',
                'body' => 'Natural fibers chosen for movement — linen that remembers the body, wool that holds soft structure without weight.',
                'image' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'title' => 'The fit',
                'body' => $process?->body
                    ?? 'We prototype, refine through fittings, and finish only when the silhouette feels honest to wear.',
                'image' => 'https://images.unsplash.com/photo-1581044777550-4cfa60707c03?auto=format&fit=crop&w=1000&q=80',
            ],
            [
                'title' => 'The edit',
                'body' => 'Small collections. If a piece does not earn its place in the wardrobe, it does not leave the atelier.',
                'image' => 'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?auto=format&fit=crop&w=1000&q=80',
            ],
        ];
    @endphp

    {{-- Chapter header — Collections pattern (top) --}}
    <section class="relative overflow-hidden border-b border-ink/8 bg-blush/50">
        <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="relative mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-28">
            <div class="fade-up ornament mb-8 justify-start">
                <span class="ornament-mark text-primary">✦</span>
            </div>
            <p class="fade-up section-label">Atelier</p>
            <h1 class="fade-up reveal-delay-1 mt-4 font-serif text-4xl italic text-ink sm:text-5xl md:text-7xl">
                About
            </h1>
            <p class="fade-up reveal-delay-2 mt-6 max-w-xl font-serif text-xl leading-relaxed text-ink/60">
                {{ $manifesto?->body
                    ?? 'A private fitting practice shaped with editorial discipline — cloth, light, and quiet form.' }}
            </p>
        </div>
    </section>

    {{-- Twin portraits --}}
    <section class="bg-soft/40 px-4 py-10 sm:px-5 sm:py-14 lg:px-10 lg:py-20">
        <div class="mx-auto grid max-w-[90rem] grid-cols-2 gap-3 sm:gap-5 lg:gap-6">
            <figure class="reveal overflow-hidden rounded-[20px] bg-blush shadow-[0_18px_40px_-20px_rgba(254,112,163,0.35)] sm:rounded-[28px]">
                <div class="aspect-[3/4] sm:aspect-[4/5]">
                    <img src="{{ $portraitA }}" alt="{{ $siteName ?? 'Yueli Studio' }}" class="h-full w-full object-cover">
                </div>
            </figure>
            <figure class="reveal reveal-delay-1 overflow-hidden rounded-[20px] bg-blush shadow-[0_18px_40px_-20px_rgba(254,112,163,0.35)] sm:rounded-[28px]">
                <div class="aspect-[3/4] sm:aspect-[4/5]">
                    <img src="{{ $portraitB }}" alt="Atelier study" class="h-full w-full object-cover">
                </div>
            </figure>
        </div>
    </section>

    {{-- Three pillars --}}
    <section class="bg-soft/25 px-4 py-12 sm:px-5 sm:py-16 lg:px-10 lg:py-24">
        <div class="mx-auto grid max-w-[90rem] gap-6 sm:gap-8 md:grid-cols-3 md:gap-6 lg:gap-8">
            @foreach($pillars as $index => $pillar)
                <article class="reveal {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                    <div class="overflow-hidden rounded-[22px] bg-porcelain shadow-[0_16px_36px_-18px_rgba(254,112,163,0.3)] sm:rounded-[28px]">
                        <div class="aspect-[4/5] max-h-72 overflow-hidden bg-blush sm:max-h-none">
                            <img src="{{ $pillar['image'] }}" alt="{{ $pillar['title'] }}" class="h-full w-full object-cover transition duration-700 hover:scale-[1.03]">
                        </div>
                        <div class="px-5 py-6 sm:px-6 sm:py-7 md:px-7 md:py-8">
                            <h2 class="font-display text-xl italic text-ink sm:text-2xl md:text-3xl">{{ $pillar['title'] }}</h2>
                            <p class="mt-3 text-[13px] leading-relaxed text-ink/55 sm:mt-4 sm:text-[14px]">
                                {{ $pillar['body'] }}
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- Soft close --}}
    <section class="border-t border-ink/6 bg-porcelain">
        <div class="mx-auto flex max-w-[90rem] flex-col items-start justify-between gap-8 px-5 py-16 md:flex-row md:items-center lg:px-10 lg:py-20">
            <div>
                <p class="text-[11px] uppercase tracking-[0.28em] text-primary">Visit</p>
                <p class="mt-3 font-display text-3xl italic text-ink md:text-4xl">Come to the fitting room.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('contact') }}" class="btn-rose">Contact</a>
                <a href="{{ route('shop.index') }}" class="btn-ghost">The Edit</a>
            </div>
        </div>
    </section>
@endsection
