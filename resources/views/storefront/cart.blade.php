@extends('layouts.storefront')

@section('title', 'Bag — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="border-b border-ink/10">
        <div class="mx-auto max-w-7xl px-5 py-16 lg:px-8">
            <p class="fade-up section-label">Boutique</p>
            <h1 class="fade-up reveal-delay-1 mt-4 font-serif text-5xl text-ink">Your bag</h1>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-12 lg:px-8">
        @if(count($items) > 0)
            <div class="grid gap-16 lg:grid-cols-12">
                <div class="lg:col-span-8">
                    <ul class="divide-y divide-ink/10">
                        @foreach($items as $key => $item)
                            <li class="reveal flex flex-col gap-6 py-8 first:pt-0 sm:flex-row sm:items-start">
                                <a href="{{ route('shop.show', $item['slug']) }}" class="block w-full shrink-0 overflow-hidden bg-ink/5 sm:w-28">
                                    <div class="aspect-[3/4]">
                                        @if(!empty($item['image']))
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-ink/20">
                                                <i data-lucide="shirt" class="h-6 w-6"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <div class="flex flex-1 flex-col gap-4 sm:flex-row sm:justify-between">
                                    <div>
                                        <a href="{{ route('shop.show', $item['slug']) }}" class="font-serif text-2xl text-ink transition hover:text-petrol">
                                            {{ $item['name'] }}
                                        </a>
                                        <div class="mt-2 space-y-1 text-[11px] uppercase tracking-[0.16em] text-ink/45">
                                            @if(!empty($item['size']))
                                                <p>Size · {{ $item['size'] }}</p>
                                            @endif
                                            @if(!empty($item['color']))
                                                <p>Color · {{ $item['color'] }}</p>
                                            @endif
                                            <p>${{ number_format($item['price'], 2) }}</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-start gap-4 sm:items-end">
                                        <form method="POST" action="{{ route('cart.update', $key) }}" class="flex items-center gap-3">
                                            @csrf
                                            @method('PATCH')
                                            <label for="qty-{{ $key }}" class="sr-only">Quantity</label>
                                            <input
                                                type="number"
                                                name="quantity"
                                                id="qty-{{ $key }}"
                                                value="{{ $item['quantity'] }}"
                                                min="0"
                                                max="10"
                                                class="input-field w-20 text-center"
                                            >
                                            <button type="submit" class="inline-flex min-h-11 items-center px-3 text-[11px] uppercase tracking-[0.18em] text-ink/50 transition hover:text-primary">
                                                Update
                                            </button>
                                        </form>

                                        <p class="text-sm tracking-[0.06em] text-ink">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </p>

                                        <form method="POST" action="{{ route('cart.destroy', $key) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex min-h-11 items-center gap-2 px-3 text-[11px] uppercase tracking-[0.18em] text-ink/40 transition hover:text-ink">
                                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <aside class="fade-up lg:col-span-4">
                    <div class="border border-ink/10 bg-ink px-7 py-8 text-bone">
                        <p class="section-label text-champagne">Summary</p>
                        <div class="mt-8 flex items-baseline justify-between border-b border-bone/15 pb-5">
                            <span class="text-[11px] uppercase tracking-[0.2em] text-bone/55">Subtotal</span>
                            <span class="font-serif text-2xl">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <p class="mt-5 text-sm leading-relaxed text-bone/55">
                            Shipping is calculated at checkout.
                        </p>
                        <a href="{{ route('checkout.index') }}" class="btn-primary mt-8 w-full bg-bone text-ink hover:bg-champagne">
                            Checkout
                        </a>
                        <a href="{{ route('shop.index') }}" class="mt-4 block text-center text-[11px] uppercase tracking-[0.2em] text-bone/50 transition hover:text-champagne">
                            Continue shopping
                        </a>
                    </div>
                </aside>
            </div>
        @else
            <div class="fade-up py-20 text-center">
                <i data-lucide="shopping-bag" class="mx-auto h-10 w-10 text-ink/25"></i>
                <h2 class="mt-6 font-serif text-3xl text-ink">Your bag is empty</h2>
                <p class="mt-3 font-serif text-lg text-ink/55">Discover pieces from the current collection.</p>
                <a href="{{ route('shop.index') }}" class="btn-ghost mt-8">Browse the shop</a>
            </div>
        @endif
    </section>
@endsection
