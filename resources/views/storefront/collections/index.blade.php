@extends('layouts.storefront')

@section('title', 'Collections — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="relative overflow-hidden border-b border-ink/8 bg-blush/50">
        <div class="pointer-events-none absolute -right-16 top-0 h-64 w-64 rounded-full bg-rose/10 blur-3xl"></div>
        <div class="relative mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-28">
            <div class="fade-up ornament mb-8 justify-start">
                <span class="ornament-mark">✦</span>
            </div>
            <p class="fade-up section-label">Archive</p>
            <h1 class="fade-up reveal-delay-1 mt-4 font-serif text-4xl italic text-ink sm:text-5xl md:text-7xl">Collections</h1>
            <p class="fade-up reveal-delay-2 mt-6 max-w-xl font-serif text-xl leading-relaxed text-ink/60">
                Seasonal chapters shaped with editorial discipline — each one a world of cloth, light, and quiet form.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-[90rem] px-5 py-16 lg:px-10 lg:py-24">
        <div class="space-y-20">
            @forelse($collections as $index => $collection)
                @php
                    $cover = $collection->cover_image
                        ? (str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/'.$collection->cover_image))
                        : null;
                    $previews = $collection->products;
                @endphp

                <article class="reveal grid items-start gap-8 lg:grid-cols-12 lg:gap-12 {{ $index % 2 === 1 ? '' : '' }}">
                    <a href="{{ route('collections.show', $collection) }}" class="lift-card group block lg:col-span-5 {{ $index % 2 === 1 ? 'lg:order-2' : '' }}">
                        <div class="media-frame img-card aspect-[3/4]">
                            @if($cover)
                                <img src="{{ $cover }}" alt="{{ $collection->name }}" class="img-editorial">
                            @endif
                            <div class="absolute inset-0 z-[1] bg-gradient-to-t from-ink/55 via-transparent to-transparent"></div>
                            <div class="absolute left-4 top-4 z-[2] rounded-full bg-porcelain/95 px-3 py-1 text-[9px] font-semibold uppercase tracking-[0.18em] text-ink shadow-md">
                                {{ $collection->season ?: 'Chapter' }}
                            </div>
                        </div>
                    </a>

                    <div class="lg:col-span-7 {{ $index % 2 === 1 ? 'lg:order-1' : '' }}">
                        @if($collection->season)
                            <p class="text-[10px] uppercase tracking-[0.28em] text-rose">{{ $collection->season }}</p>
                        @endif
                        <h2 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">
                            <a href="{{ route('collections.show', $collection) }}" class="transition hover:text-rose">{{ $collection->name }}</a>
                        </h2>

                        @if($collection->description)
                            <div class="mt-6 max-w-xl space-y-4 font-serif text-lg leading-relaxed text-ink/65">
                                @foreach(preg_split("/\n\s*\n/", trim($collection->description)) as $para)
                                    <p>{{ $para }}</p>
                                @endforeach
                            </div>
                        @endif

                        <p class="mt-6 text-[10px] uppercase tracking-[0.22em] text-mist">
                            {{ $collection->products_count }} {{ \Illuminate\Support\Str::plural('piece', $collection->products_count) }}
                        </p>

                        @if($previews->isNotEmpty())
                            <div class="mt-8 grid grid-cols-2 gap-2.5 sm:grid-cols-3 sm:gap-3">
                                @foreach($previews as $product)
                                    <a href="{{ route('shop.show', $product) }}" class="group/item soft-shadow block overflow-hidden rounded-[16px] bg-blush transition hover:shadow-[0_16px_32px_-14px_rgba(254,112,163,0.4)]">
                                        <div class="aspect-[3/4] overflow-hidden">
                                            @if($product->imageUrl())
                                                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-700 group-hover/item:scale-105">
                                            @endif
                                        </div>
                                        <div class="px-2 py-2.5">
                                            <p class="truncate font-serif text-sm italic text-ink">{{ $product->name }}</p>
                                            <p class="text-[11px] text-mist">${{ number_format($product->price, 2) }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <a href="{{ route('collections.show', $collection) }}" class="btn-ghost mt-8">
                            Enter collection
                            <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                        </a>
                    </div>
                </article>
            @empty
                <div class="fade-up py-20 text-center">
                    <p class="section-label justify-center">Collections</p>
                    <h2 class="mt-4 font-serif text-3xl italic text-ink">No collections published yet</h2>
                    <a href="{{ route('shop.index') }}" class="btn-ghost mt-8">Browse the shop</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
