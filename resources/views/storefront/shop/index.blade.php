@extends('layouts.storefront')

@section('title', 'Shop — '.($siteName ?? 'Yueli Studio'))

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        .pantry-shop {
            --mint: #55cf90;
            --mint-deep: #167a4a;
            --ink: #141716;
            --charcoal: #484b4a;
            --ivory: #f4f1eb;
            --surface: #fff;
            --surface-soft: #fbfcfb;
            background: var(--ivory);
            color: var(--ink);
            font-family: Outfit, ui-sans-serif, system-ui, sans-serif;
        }
        .pantry-shop .shop-wrap {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2rem 1rem 4rem;
        }
        @media (min-width: 640px) {
            .pantry-shop .shop-wrap { padding: 2.5rem 1.5rem 5rem; }
        }
        @media (min-width: 1024px) {
            .pantry-shop .shop-wrap { padding-left: 2rem; padding-right: 2rem; }
        }
        .pantry-shop .shop-bar {
            display: grid;
            grid-template-columns: 1fr;
            align-items: center;
            gap: 0.75rem;
        }
        @media (min-width: 1024px) {
            .pantry-shop .shop-bar {
                grid-template-columns: minmax(11.5rem, 13.5rem) minmax(11.5rem, 13.5rem) minmax(0, 1fr) 15.5rem;
            }
        }
        .pantry-shop .shop-type { position: relative; }
        .pantry-shop .shop-type__toggle {
            background: var(--surface);
            width: 100%;
            height: 2.85rem;
            color: var(--ink);
            text-align: left;
            cursor: pointer;
            border: 1px solid #167a4a2e;
            border-radius: 999px;
            justify-content: space-between;
            align-items: center;
            gap: 0.6rem;
            padding: 0 1rem 0 1.15rem;
            font-size: 0.94rem;
            display: flex;
        }
        .pantry-shop .shop-type__toggle svg {
            width: 1rem;
            height: 1rem;
            color: var(--mint-deep);
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        .pantry-shop .shop-type.is-open .shop-type__toggle { border-color: var(--mint-deep); }
        .pantry-shop .shop-type.is-open .shop-type__toggle svg { transform: rotate(180deg); }
        .pantry-shop .shop-type__menu {
            z-index: 30;
            background: var(--surface-soft);
            border: 1px solid #167a4a1f;
            border-radius: 1.15rem;
            width: max-content;
            min-width: 100%;
            max-height: 18rem;
            padding: 0.4rem;
            display: grid;
            position: absolute;
            top: calc(100% + 0.45rem);
            left: 0;
            overflow-y: auto;
            box-shadow: 0 18px 40px #1417161a;
        }
        .pantry-shop .shop-type__option {
            color: #3a403e;
            text-align: left;
            cursor: pointer;
            background: transparent;
            border: 0;
            border-radius: 0.75rem;
            width: 100%;
            padding: 0.58rem 0.9rem;
            font-size: 0.94rem;
            display: block;
        }
        .pantry-shop .shop-type__option:hover { color: var(--mint-deep); background: #55cf9024; }
        .pantry-shop .shop-type__option.is-active { color: var(--mint-deep); background: #167a4a1a; font-weight: 600; }
        .pantry-shop .shop-range {
            background: var(--surface);
            border: 1px solid #167a4a2e;
            border-radius: 999px;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 0.7rem;
            width: 100%;
            min-height: 2.85rem;
            padding: 0 1rem;
            position: relative;
        }
        .pantry-shop .shop-range__amount {
            color: var(--ink);
            white-space: nowrap;
            font-size: 0.82rem;
            font-weight: 600;
        }
        .pantry-shop .shop-range__control { height: 1.5rem; position: relative; }
        .pantry-shop .shop-range__bar {
            background: #167a4a24;
            border-radius: 999px;
            height: 3px;
            position: absolute;
            top: 50%;
            left: 0.45rem;
            right: 0.45rem;
            transform: translateY(-50%);
        }
        .pantry-shop .shop-range__bar:after {
            content: "";
            left: var(--lo, 0%);
            right: calc(100% - var(--hi, 100%));
            border-radius: inherit;
            background: #167a4a;
            height: 100%;
            position: absolute;
        }
        .pantry-shop .shop-range__control input[type="range"] {
            pointer-events: none;
            appearance: none;
            background: transparent;
            width: 100%;
            margin: 0;
            position: absolute;
            inset: 0;
        }
        .pantry-shop .shop-range__control input[type="range"]::-webkit-slider-thumb {
            background: var(--surface);
            pointer-events: auto;
            appearance: none;
            cursor: pointer;
            border: 2px solid #167a4a;
            border-radius: 999px;
            width: 16px;
            height: 16px;
            box-shadow: 0 1px 4px #1417161f;
        }
        .pantry-shop .shop-range__control input[type="range"]::-moz-range-thumb {
            background: var(--surface);
            pointer-events: auto;
            cursor: pointer;
            border: 2px solid #167a4a;
            border-radius: 999px;
            width: 16px;
            height: 16px;
        }
        .pantry-shop .shop-search {
            box-sizing: border-box;
            background: var(--surface);
            border: 1px solid #167a4a33;
            border-radius: 999px;
            align-items: center;
            gap: 0.35rem;
            width: 100%;
            min-height: 3rem;
            padding: 0.28rem 0.28rem 0.28rem 0.95rem;
            display: flex;
        }
        .pantry-shop .shop-search:focus-within {
            border-color: var(--mint-deep);
            box-shadow: 0 0 0 4px #55cf902e;
        }
        .pantry-shop .shop-search input {
            min-width: 0;
            color: var(--ink);
            background: transparent;
            border: 0;
            outline: none;
            flex: 1;
            font-size: 0.98rem;
        }
        .pantry-shop .shop-search input::placeholder { color: #8b918e; }
        .pantry-shop .shop-search button {
            color: #fff;
            cursor: pointer;
            background: #167a4a;
            border: 0;
            border-radius: 999px;
            place-items: center;
            width: 2.35rem;
            height: 2.35rem;
            display: grid;
        }
        .pantry-shop .shop-search button:hover { background: #126840; }
        .pantry-shop .shop-search svg { width: 1.05rem; height: 1.05rem; }
        .pantry-shop .product-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
            margin-top: 2.5rem;
        }
        @media (min-width: 640px) {
            .pantry-shop .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1024px) {
            .pantry-shop .product-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1.35rem; }
        }
        .pantry-shop .product-card {
            background: var(--surface-soft);
            height: 100%;
            border: 1px solid #167a4a14;
            border-radius: 1.45rem;
            margin: 0;
            padding: 0 0 1rem;
            overflow: hidden;
            transition: transform 0.4s cubic-bezier(.22, 1, .36, 1), border-color 0.3s;
        }
        .pantry-shop .product-card:hover { border-color: #a2e5c2; transform: translateY(-8px); }
        .pantry-shop .product-card__link {
            height: 100%;
            color: inherit;
            flex-direction: column;
            text-decoration: none;
            display: flex;
        }
        .pantry-shop .product-card__media {
            aspect-ratio: 1;
            background: #e7f3ec;
            position: relative;
            overflow: hidden;
        }
        .pantry-shop .product-card__image {
            object-fit: cover;
            width: 100%;
            height: 100%;
            display: block;
            transition: transform 0.8s cubic-bezier(.22, 1, .36, 1);
        }
        .pantry-shop .product-card:hover .product-card__image { transform: scale(1.06); }
        .pantry-shop .product-card__badge {
            z-index: 2;
            border: 1px solid #55cf90;
            background: #faf8f4f5;
            border-radius: 999px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--mint-deep);
            padding: 0.32rem 0.62rem;
            font-size: 0.6rem;
            font-weight: 600;
            position: absolute;
            top: 0.65rem;
            left: 0.65rem;
        }
        .pantry-shop .product-card__meta {
            flex-direction: column;
            flex: 1;
            padding: 0.9rem 1rem 0.15rem;
            display: flex;
        }
        .pantry-shop .product-card__row {
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.75rem;
            display: flex;
        }
        .pantry-shop .eyebrow {
            letter-spacing: 0.16em;
            text-transform: uppercase;
            font-size: 0.68rem;
            font-weight: 500;
            color: #484b4ab8;
        }
        .pantry-shop .product-card__price {
            text-align: right;
            color: var(--mint-deep);
            font-size: 0.9rem;
            font-weight: 600;
        }
        .pantry-shop .product-card__price .is-compare {
            color: #484b4a80;
            margin-top: 0.15rem;
            font-size: 0.72rem;
            font-weight: 400;
            text-decoration: line-through;
        }
        .pantry-shop .product-card h3 {
            font-family: "Cormorant Garamond", Georgia, serif;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin: 0.55rem 0 0;
            font-size: clamp(1.35rem, 2vw, 1.6rem);
            font-weight: 500;
            line-height: 1.12;
        }
        .pantry-shop .product-card:hover h3 { color: var(--mint-deep); }
        .pantry-shop .product-card__sub {
            color: #484b4ac2;
            margin: 0.4rem 0 0;
            font-size: 0.88rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .pantry-shop .product-card__hint {
            letter-spacing: 0.16em;
            text-transform: uppercase;
            width: fit-content;
            color: var(--mint-deep);
            align-items: center;
            gap: 0.35rem;
            margin-top: auto;
            padding: 0.85rem 0 0;
            font-size: 0.64rem;
            font-weight: 600;
            display: inline-flex;
        }
        .pantry-shop .product-card__hint:after { content: "→"; display: inline-block; }
        .pantry-shop .product-card:hover .product-card__hint:after { transform: translateX(0.28rem); }
        .pantry-shop .page-nav {
            justify-content: center;
            align-items: center;
            gap: 0.85rem;
            margin-top: 2.5rem;
            display: flex;
            flex-wrap: wrap;
        }
        .pantry-shop .page-nav__status {
            min-width: 8rem;
            color: var(--charcoal);
            text-align: center;
            font-size: 0.92rem;
        }
        .pantry-shop .page-nav__prev,
        .pantry-shop .page-nav__next {
            letter-spacing: 0.16em;
            text-transform: uppercase;
            border-radius: 999px;
            justify-content: center;
            align-items: center;
            min-width: 7.5rem;
            min-height: 2.8rem;
            padding: 0.55rem 1.1rem;
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
        }
        .pantry-shop .page-nav__prev { background: var(--surface); color: var(--mint-deep); border: 1px solid #167a4a47; }
        .pantry-shop .page-nav__next { color: #fff; background: #167a4a; }
        .pantry-shop .page-nav__prev:hover,
        .pantry-shop .page-nav__next:hover { color: #fff; background: #126840; }
        .pantry-shop .page-nav__prev.is-disabled,
        .pantry-shop .page-nav__next.is-disabled { opacity: 0.4; pointer-events: none; }
        .pantry-shop .shop-empty { text-align: center; padding: 5rem 1rem; font-family: "Cormorant Garamond", Georgia, serif; font-size: 2rem; }
    </style>
@endpush

@section('content')
    <section class="pantry-shop">
        <div class="shop-wrap">
            <form method="GET" action="{{ route('shop.index') }}" class="shop-toolbar">
                <h1 class="sr-only">Shop</h1>
                <div
                    class="shop-bar"
                    x-data="{
                        min: {{ $min }},
                        max: {{ $max }},
                        floor: {{ $priceFloor }},
                        ceil: {{ $priceCeil }},
                        setMin(value) { this.min = Math.min(Number(value), this.max); },
                        setMax(value) { this.max = Math.max(Number(value), this.min); },
                        percent(value) {
                            if (this.ceil === this.floor) return 0;
                            return ((value - this.floor) / (this.ceil - this.floor)) * 100;
                        }
                    }"
                >
                    <div class="shop-type" x-data="{ open: false, pick(value) { this.$refs.field.value = value; this.$refs.field.form.requestSubmit(); } }" :class="open && 'is-open'" @click.outside="open = false">
                        <input type="hidden" name="collection" value="{{ request('collection') }}" x-ref="field">
                        <button type="button" class="shop-type__toggle" @click="open = !open" :aria-expanded="open.toString()">
                            <span>{{ $collections->firstWhere('slug', request('collection'))->name ?? 'All collections' }}</span>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6.2 8 10.2 12 6.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <div class="shop-type__menu" x-cloak x-show="open" role="listbox">
                            <button type="button" @click="pick('')" class="shop-type__option {{ request('collection') ? '' : 'is-active' }}">All collections</button>
                            @foreach($collections as $collection)
                                <button type="button" @click="pick('{{ $collection->slug }}')" class="shop-type__option {{ request('collection') === $collection->slug ? 'is-active' : '' }}">{{ $collection->name }}</button>
                            @endforeach
                        </div>
                    </div>

                    <div class="shop-type" x-data="{ open: false, pick(value) { this.$refs.field.value = value; this.$refs.field.form.requestSubmit(); } }" :class="open && 'is-open'" @click.outside="open = false">
                        <input type="hidden" name="type" value="{{ request('type') }}" x-ref="field">
                        <button type="button" class="shop-type__toggle" @click="open = !open" :aria-expanded="open.toString()">
                            <span>{{ ['featured' => 'Featured', 'sale' => 'Sale'][request('type')] ?? 'All types' }}</span>
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6.2 8 10.2 12 6.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <div class="shop-type__menu" x-cloak x-show="open" role="listbox">
                            <button type="button" @click="pick('')" class="shop-type__option {{ request('type') ? '' : 'is-active' }}">All types</button>
                            <button type="button" @click="pick('featured')" class="shop-type__option {{ request('type') === 'featured' ? 'is-active' : '' }}">Featured</button>
                            <button type="button" @click="pick('sale')" class="shop-type__option {{ request('type') === 'sale' ? 'is-active' : '' }}">Sale</button>
                        </div>
                    </div>

                    @if($priceCeil > $priceFloor)
                        <div class="shop-range" :style="`--lo:${percent(min)}%; --hi:${percent(max)}%`">
                            <span class="shop-range__amount" x-text="'$' + Number(min).toLocaleString()"></span>
                            <div class="shop-range__control">
                                <span class="shop-range__bar" aria-hidden="true"></span>
                                <label class="sr-only" for="shop-min-price">From</label>
                                <input id="shop-min-price" type="range" name="min" :min="floor" :max="ceil" :value="min" @input="setMin($event.target.value)" @change="$el.form.requestSubmit()">
                                <label class="sr-only" for="shop-max-price">To</label>
                                <input id="shop-max-price" type="range" name="max" :min="floor" :max="ceil" :value="max" @input="setMax($event.target.value)" @change="$el.form.requestSubmit()">
                            </div>
                            <span class="shop-range__amount" x-text="'$' + Number(max).toLocaleString()"></span>
                        </div>
                    @endif

                    <div class="shop-search">
                        <label class="sr-only" for="shop-q">Search pieces</label>
                        <input id="shop-q" type="search" name="q" value="{{ request('q') }}" placeholder="Search pieces">
                        <button type="submit" aria-label="Search pieces">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <circle cx="11" cy="11" r="6.25"/>
                                <path d="M16 16.5 20 20.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            @if($products->isNotEmpty())
                <div class="product-grid">
                    @foreach($products as $product)
                        @php $onSale = $product->compare_at_price && $product->compare_at_price > $product->price; @endphp
                        <article class="product-card">
                            <a href="{{ route('shop.show', $product) }}" class="product-card__link">
                                <div class="product-card__media">
                                    @if($product->imageUrl())
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="product-card__image" loading="lazy">
                                    @endif
                                    @if($onSale)
                                        <span class="product-card__badge">Sale</span>
                                    @elseif($product->is_featured)
                                        <span class="product-card__badge">Featured</span>
                                    @endif
                                </div>
                                <div class="product-card__meta">
                                    <div class="product-card__row">
                                        <p class="eyebrow">{{ $product->collection->name ?? 'Piece' }}</p>
                                        <div class="product-card__price">
                                            <p>${{ number_format($product->price, 0) }}</p>
                                            @if($onSale)
                                                <p class="is-compare">${{ number_format($product->compare_at_price, 0) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <h3>{{ $product->name }}</h3>
                                    @if($product->short_description)
                                        <p class="product-card__sub">{{ $product->short_description }}</p>
                                    @endif
                                    <span class="product-card__hint">View piece</span>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                <nav class="page-nav" aria-label="Shop pages">
                    @if($products->onFirstPage())
                        <span class="page-nav__prev is-disabled">Previous</span>
                    @else
                        <a class="page-nav__prev" href="{{ $products->previousPageUrl() }}">Previous</a>
                    @endif
                    <p class="page-nav__status">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</p>
                    @if($products->hasMorePages())
                        <a class="page-nav__next" href="{{ $products->nextPageUrl() }}">Next</a>
                    @else
                        <span class="page-nav__next is-disabled">Next</span>
                    @endif
                </nav>
            @else
                <div class="shop-empty">Nothing found</div>
            @endif
        </div>
    </section>
@endsection
