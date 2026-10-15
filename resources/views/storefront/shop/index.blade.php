@extends('layouts.storefront')

@section('title', 'The Edit — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="border-b border-ink/8 bg-blush/40">
        <div class="mx-auto max-w-[90rem] px-5 py-20 lg:px-10 lg:py-28">
            <p class="fade-up section-label">Boutique</p>
            <h1 class="fade-up reveal-delay-1 mt-4 font-serif text-4xl italic text-ink sm:text-5xl md:text-7xl">The Edit</h1>
            <p class="fade-up reveal-delay-2 mt-6 max-w-lg font-serif text-xl leading-relaxed text-ink/60">
                Pieces from the journal — select, bag, and wear with ease.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-[90rem] px-5 py-14 lg:px-10">
        <form method="GET" action="{{ route('shop.index') }}" class="fade-up mb-14 flex flex-col gap-6 border-b border-ink/8 pb-10 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex flex-1 flex-col gap-6 sm:flex-row sm:items-end">
                <div class="w-full sm:max-w-xs">
                    <label for="q" class="mb-2 block text-[10px] uppercase tracking-[0.24em] text-mist">Search</label>
                    <input type="search" name="q" id="q" value="{{ request('q') }}" placeholder="Find a piece…" class="input-field">
                </div>
                <div class="w-full sm:max-w-xs">
                    <label for="collection" class="mb-2 block text-[10px] uppercase tracking-[0.24em] text-mist">Collection</label>
                    <select name="collection" id="collection" class="input-field appearance-none">
                        <option value="">All chapters</option>
                        @foreach($collections as $collection)
                            <option value="{{ $collection->slug }}" @selected(request('collection') === $collection->slug)>
                                {{ $collection->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-ghost shrink-0">Apply</button>
        </form>

        @if($products->isNotEmpty())
            <div class="grid gap-x-8 gap-y-14 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $index => $product)
                    <a href="{{ route('shop.show', $product) }}" class="reveal product-box group {{ 'reveal-delay-'.(($index % 3) + 1) }}">
                        <div class="product-box-media media-frame aspect-[3/4]">
                            @if($product->is_featured)
                                <span class="product-box-tag">Featured</span>
                            @elseif($product->compare_at_price && $product->compare_at_price > $product->price)
                                <span class="product-box-tag">Sale</span>
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
                                <h2 class="font-serif text-2xl italic leading-tight text-ink transition group-hover:text-rose">{{ $product->name }}</h2>
                                <div class="shrink-0 pt-1 text-right">
                                    <p class="text-[12px] tracking-[0.08em] text-ink">${{ number_format($product->price, 2) }}</p>
                                    @if($product->compare_at_price && $product->compare_at_price > $product->price)
                                        <p class="text-[11px] text-mist/50 line-through">${{ number_format($product->compare_at_price, 2) }}</p>
                                    @endif
                                </div>
                            </div>
                            @if($product->short_description)
                                <p class="text-sm leading-relaxed text-mist">{{ \Illuminate\Support\Str::limit($product->short_description, 64) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-16">{{ $products->links() }}</div>
        @else
            <div class="fade-up py-24 text-center">
                <p class="section-label">The Edit</p>
                <h2 class="mt-4 font-serif text-3xl italic text-ink">Nothing found</h2>
                <a href="{{ route('shop.index') }}" class="btn-ghost mt-8">Clear filters</a>
            </div>
        @endif
    </section>
@endsection
