@extends('layouts.storefront')

@section('title', 'Shop — '.($siteName ?? 'Yueli Studio'))

@push('styles')
    <style>
        .atelier-shop {
            --accent: #e23d86;
            --accent-soft: #fe70a3;
            --ink: #1c1517;
            --mist: #7d6876;
            --ivory: #faf6f2;
            --surface: #fff;
            background: var(--ivory);
            color: var(--ink);
        }
        .atelier-shop .shop-wrap {
            max-width: 80rem;
            margin: 0 auto;
            padding: 2rem 1rem 4rem;
        }
        @media (min-width: 640px) {
            .atelier-shop .shop-wrap { padding: 2.5rem 1.5rem 5rem; }
        }
        @media (min-width: 1024px) {
            .atelier-shop .shop-wrap { padding-left: 2rem; padding-right: 2rem; }
        }
        .atelier-shop .shop-intro {
            margin-bottom: 1.75rem;
            max-width: 40rem;
        }
        .atelier-shop .shop-intro__label {
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--accent);
            font-size: 0.68rem;
            font-weight: 600;
        }
        .atelier-shop .shop-intro__title {
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: clamp(2.4rem, 5vw, 3.4rem);
            font-weight: 500;
            font-style: italic;
            line-height: 1.05;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin: 0.55rem 0 0;
        }
        .atelier-shop .shop-intro__text {
            color: color-mix(in srgb, var(--ink) 55%, transparent);
            margin: 0.85rem 0 0;
            font-size: 1.02rem;
            line-height: 1.6;
            font-weight: 400;
        }
        .atelier-shop .shop-bar {
            display: grid;
            grid-template-columns: 1fr;
            align-items: center;
            gap: 0.75rem;
        }
        @media (min-width: 1024px) {
            .atelier-shop .shop-bar {
                grid-template-columns: minmax(11.5rem, 13.5rem) minmax(11.5rem, 13.5rem) minmax(0, 1fr) 15.5rem;
            }
        }
        .atelier-shop .shop-type { position: relative; }
        .atelier-shop .shop-type__toggle {
            background: var(--surface);
            width: 100%;
            height: 2.85rem;
            color: var(--ink);
            text-align: left;
            cursor: pointer;
            border: 1px solid rgba(226, 61, 134, 0.18);
            border-radius: 999px;
            justify-content: space-between;
            align-items: center;
            gap: 0.6rem;
            padding: 0 1rem 0 1.15rem;
            font-size: 0.92rem;
            display: flex;
        }
        .atelier-shop .shop-type__toggle svg {
            width: 1rem;
            height: 1rem;
            color: var(--accent);
            flex-shrink: 0;
            transition: transform 0.2s;
        }
        .atelier-shop .shop-type.is-open .shop-type__toggle { border-color: var(--accent); }
        .atelier-shop .shop-type.is-open .shop-type__toggle svg { transform: rotate(180deg); }
        .atelier-shop .shop-type__menu {
            z-index: 30;
            background: var(--surface);
            border: 1px solid rgba(226, 61, 134, 0.12);
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
            box-shadow: 0 18px 40px rgba(28, 21, 23, 0.1);
        }
        .atelier-shop .shop-type__option {
            color: var(--mist);
            text-align: left;
            cursor: pointer;
            background: transparent;
            border: 0;
            border-radius: 0.75rem;
            width: 100%;
            padding: 0.58rem 0.9rem;
            font-size: 0.92rem;
            display: block;
        }
        .atelier-shop .shop-type__option:hover { color: var(--accent); background: rgba(254, 112, 163, 0.12); }
        .atelier-shop .shop-type__option.is-active { color: var(--accent); background: rgba(226, 61, 134, 0.1); font-weight: 600; }
        .atelier-shop .shop-range {
            background: var(--surface);
            border: 1px solid rgba(226, 61, 134, 0.18);
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
        .atelier-shop .shop-range__amount {
            color: var(--ink);
            white-space: nowrap;
            font-size: 0.82rem;
            font-weight: 600;
        }
        .atelier-shop .shop-range__control { height: 1.5rem; position: relative; }
        .atelier-shop .shop-range__bar {
            background: rgba(226, 61, 134, 0.14);
            border-radius: 999px;
            height: 3px;
            position: absolute;
            top: 50%;
            left: 0.45rem;
            right: 0.45rem;
            transform: translateY(-50%);
        }
        .atelier-shop .shop-range__bar:after {
            content: "";
            left: var(--lo, 0%);
            right: calc(100% - var(--hi, 100%));
            border-radius: inherit;
            background: var(--accent);
            height: 100%;
            position: absolute;
        }
        .atelier-shop .shop-range__control input[type="range"] {
            pointer-events: none;
            appearance: none;
            background: transparent;
            width: 100%;
            margin: 0;
            position: absolute;
            inset: 0;
        }
        .atelier-shop .shop-range__control input[type="range"]::-webkit-slider-thumb {
            background: var(--surface);
            pointer-events: auto;
            appearance: none;
            cursor: pointer;
            border: 2px solid var(--accent);
            border-radius: 999px;
            width: 16px;
            height: 16px;
            box-shadow: 0 1px 4px rgba(28, 21, 23, 0.12);
        }
        .atelier-shop .shop-range__control input[type="range"]::-moz-range-thumb {
            background: var(--surface);
            pointer-events: auto;
            cursor: pointer;
            border: 2px solid var(--accent);
            border-radius: 999px;
            width: 16px;
            height: 16px;
        }
        .atelier-shop .shop-search {
            box-sizing: border-box;
            background: var(--surface);
            border: 1px solid rgba(226, 61, 134, 0.2);
            border-radius: 999px;
            align-items: center;
            gap: 0.35rem;
            width: 100%;
            min-height: 3rem;
            padding: 0.28rem 0.28rem 0.28rem 0.95rem;
            display: flex;
        }
        .atelier-shop .shop-search:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(254, 112, 163, 0.16);
        }
        .atelier-shop .shop-search input {
            min-width: 0;
            color: var(--ink);
            background: transparent;
            border: 0;
            outline: none;
            flex: 1;
            font-size: 0.95rem;
        }
        .atelier-shop .shop-search input::placeholder { color: #a898a2; }
        .atelier-shop .shop-search button {
            color: #fff;
            cursor: pointer;
            background: var(--accent);
            border: 0;
            border-radius: 999px;
            place-items: center;
            width: 2.35rem;
            height: 2.35rem;
            display: grid;
        }
        .atelier-shop .shop-search button:hover { background: #c83274; }
        .atelier-shop .shop-search svg { width: 1.05rem; height: 1.05rem; }

        .atelier-shop .product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2.25rem;
        }
        @media (min-width: 768px) {
            .atelier-shop .product-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1.25rem; }
        }
        @media (min-width: 1024px) {
            .atelier-shop .product-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1.35rem; }
        }

        .atelier-shop .product-card {
            background: var(--surface);
            height: 100%;
            border: 1px solid rgba(28, 21, 23, 0.08);
            border-radius: 1.45rem;
            margin: 0;
            padding: 0 0 0.95rem;
            overflow: hidden;
            box-shadow: 0 14px 32px -16px rgba(28, 21, 23, 0.14);
            transition: transform 0.45s cubic-bezier(.22, 1, .36, 1), box-shadow 0.4s ease, border-color 0.3s;
        }
        .atelier-shop .product-card:hover {
            border-color: rgba(226, 61, 134, 0.28);
            transform: translateY(-6px);
            box-shadow: 0 22px 44px -16px rgba(226, 61, 134, 0.22);
        }
        .atelier-shop .product-card.reveal { opacity: 0; transform: translateY(1.15rem); }
        .atelier-shop .product-card.reveal.is-visible { opacity: 1; transform: none; }
        .atelier-shop .product-card.reveal.is-visible:hover { transform: translateY(-6px); }
        .atelier-shop .product-card__link {
            height: 100%;
            color: inherit;
            flex-direction: column;
            text-decoration: none;
            display: flex;
        }
        .atelier-shop .product-card__media {
            aspect-ratio: 1 / 1.08;
            max-height: 17rem;
            background: #f3ecef;
            position: relative;
            overflow: hidden;
            border-radius: 1.35rem 1.35rem 0 0;
            border-bottom: 1px solid rgba(28, 21, 23, 0.06);
        }
        @media (min-width: 1024px) {
            .atelier-shop .product-card__media { max-height: 18.5rem; }
        }
        .atelier-shop .product-card__image {
            object-fit: cover;
            object-position: center 18%;
            width: 100%;
            height: 100%;
            display: block;
            transition: transform 0.8s cubic-bezier(.22, 1, .36, 1);
        }
        .atelier-shop .product-card:hover .product-card__image { transform: scale(1.05); }
        .atelier-shop .product-card__badge {
            z-index: 2;
            border: 1px solid rgba(226, 61, 134, 0.35);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 999px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--accent);
            padding: 0.32rem 0.62rem;
            font-size: 0.58rem;
            font-weight: 600;
            position: absolute;
            top: 0.65rem;
            left: 0.65rem;
        }
        .atelier-shop .product-card__meta {
            flex-direction: column;
            flex: 1;
            padding: 0.85rem 1rem 0.1rem;
            display: flex;
        }
        .atelier-shop .product-card__row {
            justify-content: space-between;
            align-items: flex-start;
            gap: 0.75rem;
            display: flex;
        }
        .atelier-shop .eyebrow {
            letter-spacing: 0.16em;
            text-transform: uppercase;
            font-size: 0.64rem;
            font-weight: 500;
            color: color-mix(in srgb, var(--mist) 85%, transparent);
        }
        .atelier-shop .product-card__price {
            text-align: right;
            color: var(--accent);
            font-size: 0.88rem;
            font-weight: 600;
        }
        .atelier-shop .product-card__price .is-compare {
            color: color-mix(in srgb, var(--mist) 75%, transparent);
            margin-top: 0.15rem;
            font-size: 0.7rem;
            font-weight: 400;
            text-decoration: line-through;
        }
        .atelier-shop .product-card h3 {
            font-family: "Cormorant Garamond", Georgia, serif;
            letter-spacing: -0.02em;
            color: var(--ink);
            margin: 0.5rem 0 0;
            font-size: clamp(1.25rem, 2vw, 1.5rem);
            font-weight: 500;
            line-height: 1.12;
        }
        .atelier-shop .product-card:hover h3 { color: var(--accent); }
        .atelier-shop .product-card__sub {
            color: color-mix(in srgb, var(--ink) 52%, transparent);
            margin: 0.35rem 0 0;
            font-size: 0.84rem;
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .atelier-shop .product-card__hint {
            letter-spacing: 0.16em;
            text-transform: uppercase;
            width: fit-content;
            color: var(--accent);
            align-items: center;
            gap: 0.35rem;
            margin-top: auto;
            padding: 0.75rem 0 0;
            font-size: 0.6rem;
            font-weight: 600;
            display: inline-flex;
        }
        .atelier-shop .product-card__hint:after { content: "→"; display: inline-block; transition: transform 0.25s ease; }
        .atelier-shop .product-card:hover .product-card__hint:after { transform: translateX(0.25rem); }

        .atelier-shop .page-nav {
            justify-content: center;
            align-items: center;
            gap: 0.85rem;
            margin-top: 2.5rem;
            display: flex;
            flex-wrap: wrap;
        }
        .atelier-shop .page-nav__status {
            min-width: 8rem;
            color: var(--mist);
            text-align: center;
            font-size: 0.88rem;
        }
        .atelier-shop .page-nav__prev,
        .atelier-shop .page-nav__next {
            letter-spacing: 0.16em;
            text-transform: uppercase;
            border-radius: 999px;
            justify-content: center;
            align-items: center;
            min-width: 7.5rem;
            min-height: 2.7rem;
            padding: 0.55rem 1.1rem;
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
        }
        .atelier-shop .page-nav__prev { background: var(--surface); color: var(--accent); border: 1px solid rgba(226, 61, 134, 0.28); }
        .atelier-shop .page-nav__next { color: #fff; background: var(--accent); border: 1px solid var(--accent); }
        .atelier-shop .page-nav__prev:hover,
        .atelier-shop .page-nav__next:hover { color: #fff; background: #c83274; border-color: #c83274; }
        .atelier-shop .page-nav__prev.is-disabled,
        .atelier-shop .page-nav__next.is-disabled { opacity: 0.4; pointer-events: none; }
        .atelier-shop .shop-empty {
            text-align: center;
            padding: 5rem 1rem;
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: 2rem;
            font-style: italic;
            color: var(--mist);
        }

        @media (max-width: 639px) {
            .atelier-shop .product-card__media { max-height: 13.5rem; }
            .atelier-shop .product-card h3 { font-size: 1.15rem; }
        }
    </style>
@endpush

@section('content')
    <section class="atelier-shop">
        <div class="shop-wrap">
            <div class="shop-intro fade-up">
                <p class="shop-intro__label">{{ $intro->subtitle ?? 'Boutique' }}</p>
                <h1 class="shop-intro__title">{{ $intro->title ?? 'Shop' }}</h1>
                <p class="shop-intro__text">
                    {{ $intro->body ?? 'Soft tees and quiet staples from the atelier — choose a piece, bag it, and wear it with ease. Each garment is edited for everyday form: clean lines, calm color, and cloth that feels light on the body.' }}
                </p>
            </div>

            <form method="GET" action="{{ route('shop.index') }}" class="shop-toolbar">
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
                <div class="product-grid stagger-children">
                    @foreach($products as $product)
                        @php $onSale = $product->compare_at_price && $product->compare_at_price > $product->price; @endphp
                        <article class="product-card reveal">
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
