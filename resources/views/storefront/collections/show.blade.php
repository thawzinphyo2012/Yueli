@extends('layouts.storefront')

@section('title', $collection->name.' — '.($siteName ?? 'Yueli Studio'))

@section('content')
    @php
        $cover = $collection->cover_image
            ? (str_starts_with($collection->cover_image, 'http') ? $collection->cover_image : asset('storage/'.$collection->cover_image))
            : null;
        $paragraphs = $collection->description
            ? preg_split("/\n\s*\n/", trim($collection->description))
            : [];
    @endphp

    <section class="grain relative min-h-[70vh] overflow-hidden bg-ink text-porcelain">
        @if($cover)
            <img src="{{ $cover }}" alt="" class="ken-burns absolute inset-0 h-full w-full object-cover opacity-55">
            <div class="absolute inset-0 bg-gradient-to-r from-ink/90 via-ink/55 to-ink/25"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-ink/80 via-transparent to-ink/30"></div>
        @endif
        <div class="hero-sparks opacity-50" aria-hidden="true"></div>

        <div class="relative z-10 mx-auto flex min-h-[70vh] max-w-[90rem] flex-col justify-end px-5 pb-16 pt-28 lg:px-10">
            <a href="{{ route('collections.index') }}" class="fade-up inline-flex min-h-11 items-center gap-2 text-[10px] uppercase tracking-[0.24em] text-porcelain/55 transition hover:text-rose">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                Collections
            </a>
            @if($collection->season)
                <p class="fade-up reveal-delay-1 mt-8 text-[11px] uppercase tracking-[0.28em] text-rose">{{ $collection->season }}</p>
            @endif
            <h1 class="fade-up reveal-delay-2 mt-4 font-serif text-5xl italic md:text-6xl lg:text-7xl">{{ $collection->name }}</h1>
            @if(!empty($paragraphs[0]))
                <p class="fade-up reveal-delay-3 mt-6 max-w-2xl font-serif text-xl leading-relaxed text-porcelain/70">
                    {{ $paragraphs[0] }}
                </p>
            @endif
            <p class="fade-up reveal-delay-4 mt-8 text-[10px] uppercase tracking-[0.22em] text-porcelain/45">
                {{ $collection->products->count() }} {{ \Illuminate\Support\Str::plural('piece', $collection->products->count()) }}
            </p>
        </div>
    </section>

    @if(count($paragraphs) > 1)
        <section class="section-shell border-b border-ink/8 bg-blush/40">
            <div class="mx-auto max-w-3xl px-5 py-20 text-center lg:px-10">
                <div class="fade-up ornament mb-8">
                    <span class="ornament-mark">✦</span>
                </div>
                <p class="fade-up section-label justify-center">Chapter notes</p>
                <div class="fade-up reveal-delay-1 mt-8 space-y-5 text-left font-serif text-xl leading-relaxed text-ink/70">
                    @foreach(array_slice($paragraphs, 1) as $para)
                        <p>{{ $para }}</p>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($moodImages->isNotEmpty())
        <section class="mx-auto max-w-[90rem] px-5 py-20 lg:px-10">
            <div class="fade-up mb-10 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="section-label">Mood</p>
                    <h2 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">From the lookbooks</h2>
                </div>
                <a href="{{ route('lookbook.index') }}" class="text-[10px] uppercase tracking-[0.24em] text-mist transition hover:text-rose">
                    View lookbook →
                </a>
            </div>

            <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:gap-5">
                @foreach($moodImages as $index => $image)
                    @php
                        $url = str_starts_with($image, 'http') ? $image : asset('storage/'.$image);
                    @endphp
                    <figure class="reveal overflow-hidden rounded-[20px] bg-blush shadow-[0_14px_34px_-14px_rgba(254,112,163,0.38)] {{ $index === 0 ? 'col-span-2 aspect-[21/9] md:col-span-2 md:row-span-2 md:aspect-auto md:min-h-[28rem]' : 'aspect-[3/4]' }} {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                        <img src="{{ $url }}" alt="{{ $collection->name }} mood {{ $index + 1 }}" class="h-full w-full object-cover transition duration-700 hover:scale-[1.03]">
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

    <section class="border-t border-ink/8 bg-blush/50">
        <div class="mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-24">
            @if($collection->products->isNotEmpty())
                <div class="fade-up mb-12 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="section-label">The edit</p>
                        <h2 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">Pieces in this collection</h2>
                        <p class="mt-4 max-w-lg font-serif text-lg text-ink/55">
                            Shop the garments that belong to this chapter.
                        </p>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-mist">{{ $collection->products->count() }} items</p>
                </div>

                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($collection->products as $index => $product)
                        <a href="{{ route('shop.show', $product) }}" class="reveal product-box group {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                            <div class="product-box-media media-frame aspect-[3/4]">
                                @if($product->is_featured)
                                    <span class="product-box-tag">Featured</span>
                                @endif
                                @if($product->imageUrl())
                                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="img-editorial">
                                @endif
                            </div>
                            <div class="product-box-body">
                                <div class="product-box-meta">
                                    <h3 class="font-serif text-2xl italic leading-tight text-ink transition group-hover:text-rose">{{ $product->name }}</h3>
                                    <p class="shrink-0 pt-1 text-[12px] tracking-[0.08em] text-ink">${{ number_format($product->price, 2) }}</p>
                                </div>
                                @if($product->short_description)
                                    <p class="text-sm leading-relaxed text-mist">{{ \Illuminate\Support\Str::limit($product->short_description, 64) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="fade-up py-16 text-center">
                    <p class="font-serif text-2xl italic text-ink/60">No products in this collection yet.</p>
                    <a href="{{ route('shop.index') }}" class="btn-ghost mt-8">Browse the shop</a>
                </div>
            @endif
        </div>
    </section>

    @if($collection->lookbooks->isNotEmpty())
        <section class="mx-auto max-w-[90rem] px-5 py-20 lg:px-10">
            <div class="fade-up ornament mb-10">
                <span class="ornament-mark">✦</span>
            </div>
            <div class="fade-up mb-10 text-center">
                <p class="section-label justify-center">Related stories</p>
                <h2 class="mt-3 font-serif text-4xl italic text-ink">Lookbooks for this chapter</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($collection->lookbooks as $index => $lookbook)
                    <a href="{{ route('lookbook.show', $lookbook) }}" class="reveal product-box group {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                        <div class="product-box-media media-frame aspect-[4/5]">
                            <span class="product-box-tag">{{ $lookbook->is_campaign ? 'Campaign' : 'Editorial' }}</span>
                            @if($lookbook->coverUrl())
                                <img src="{{ $lookbook->coverUrl() }}" alt="{{ $lookbook->title }}" class="img-editorial">
                            @endif
                        </div>
                        <div class="product-box-body">
                            <h3 class="font-serif text-2xl italic text-ink transition group-hover:text-rose">{{ $lookbook->title }}</h3>
                            @if($lookbook->description)
                                <p class="text-sm leading-relaxed text-mist">{{ \Illuminate\Support\Str::limit(strip_tags($lookbook->description), 90) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="border-t border-ink/8 bg-ink text-porcelain">
        <div class="mx-auto flex max-w-[90rem] flex-col items-start justify-between gap-6 px-5 py-14 sm:flex-row sm:items-center lg:px-10">
            <div>
                <p class="section-label text-rose">Continue</p>
                <p class="mt-3 font-serif text-2xl italic">Explore more chapters</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('collections.index') }}" class="btn-outline border-porcelain/30">All collections</a>
                <a href="{{ route('shop.index') }}" class="btn-rose">Shop the edit</a>
            </div>
        </div>
    </section>
@endsection
