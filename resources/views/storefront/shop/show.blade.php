@extends('layouts.storefront')

@section('title', $product->name.' — '.($siteName ?? 'Yueli Studio'))

@section('content')
    @php
        $gallery = collect($product->gallery ?? [])->filter()->values();
        $sizes = collect($product->sizes ?? [])->filter()->values();
        $colors = collect($product->colors ?? [])->filter()->values();
    @endphp

    <section class="mx-auto max-w-7xl px-5 py-12 lg:grid lg:grid-cols-2 lg:gap-16 lg:px-8 lg:py-20">
        <div class="reveal space-y-4">
            <div class="aspect-[3/4] overflow-hidden bg-ink/5">
                @if($product->imageUrl())
                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full w-full items-center justify-center text-ink/20">
                        <i data-lucide="shirt" class="h-14 w-14"></i>
                    </div>
                @endif
            </div>
            @if($gallery->isNotEmpty())
                <div class="grid grid-cols-3 gap-3">
                    @foreach($gallery as $image)
                        @php
                            $url = str_starts_with($image, 'http') ? $image : asset('storage/'.$image);
                        @endphp
                        <div class="aspect-square overflow-hidden bg-ink/5">
                            <img src="{{ $url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="fade-up mt-10 lg:mt-0 lg:pt-6">
            <a href="{{ route('shop.index') }}" class="inline-flex min-h-11 items-center gap-2 text-[10px] uppercase tracking-[0.24em] text-mist transition hover:text-rose">
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                The Edit
            </a>

            @if($product->collection)
                <p class="mt-8 section-label">
                    <a href="{{ route('collections.show', $product->collection) }}" class="hover:text-ink">{{ $product->collection->name }}</a>
                </p>
            @endif

            <h1 class="mt-3 font-serif text-4xl italic text-ink md:text-5xl">{{ $product->name }}</h1>

            <div class="mt-5 flex items-baseline gap-4">
                <p class="text-lg tracking-[0.06em] text-ink">${{ number_format($product->price, 2) }}</p>
                @if($product->compare_at_price && $product->compare_at_price > $product->price)
                    <p class="text-sm tracking-[0.06em] text-ink/35 line-through">${{ number_format($product->compare_at_price, 2) }}</p>
                @endif
            </div>

            @if($product->short_description)
                <p class="mt-6 font-serif text-lg leading-relaxed text-ink/70">{{ $product->short_description }}</p>
            @endif

            <form method="POST" action="{{ route('cart.store') }}" class="mt-10 space-y-8">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if($sizes->isNotEmpty())
                    <div>
                        <label for="size" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Size</label>
                        <select name="size" id="size" required class="input-field appearance-none">
                            <option value="" disabled selected>Select size</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size }}">{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if($colors->isNotEmpty())
                    <div>
                        <label for="color" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Color</label>
                        <select name="color" id="color" required class="input-field appearance-none">
                            <option value="" disabled selected>Select color</option>
                            @foreach($colors as $color)
                                <option value="{{ $color }}">{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label for="quantity" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="10" class="input-field w-28">
                </div>

                <button type="submit" class="btn-rose w-full sm:w-auto" @disabled($product->stock <= 0)>
                    @if($product->stock <= 0)
                        Sold out
                    @else
                        Add to bag
                        <i data-lucide="shopping-bag" class="h-3.5 w-3.5"></i>
                    @endif
                </button>
            </form>

            @if($product->description)
                <div class="mt-12 border-t border-ink/10 pt-10">
                    <p class="section-label mb-4">Details</p>
                    <div class="space-y-4 font-serif text-lg leading-relaxed text-ink/70">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif

            @if($product->sku)
                <p class="mt-8 text-[11px] uppercase tracking-[0.18em] text-ink/35">SKU · {{ $product->sku }}</p>
            @endif
        </div>
    </section>

    @if($related->isNotEmpty())
        <section class="border-t border-ink/10 bg-bone">
            <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8">
                <p class="fade-up section-label">You may also like</p>
                <h2 class="fade-up reveal-delay-1 mt-3 font-serif text-3xl text-ink">Related pieces</h2>
                <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($related as $index => $item)
                        <a href="{{ route('shop.show', $item) }}" class="reveal group block {{ 'reveal-delay-'.(($index % 4) + 1) }}">
                            <div class="aspect-[3/4] overflow-hidden bg-ink/5">
                                @if($item->imageUrl())
                                    <img src="{{ $item->imageUrl() }}" alt="{{ $item->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]">
                                @endif
                            </div>
                            <h3 class="mt-4 font-serif text-xl text-ink transition group-hover:text-petrol">{{ $item->name }}</h3>
                            <p class="mt-1 text-[12px] text-ink/50">${{ number_format($item->price, 2) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
