@extends('layouts.storefront')

@section('title', 'Checkout — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="border-b border-ink/10">
        <div class="mx-auto max-w-7xl px-5 py-16 lg:px-8">
            <p class="fade-up section-label">Checkout</p>
            <h1 class="fade-up reveal-delay-1 mt-4 font-serif text-5xl text-ink">Complete your order</h1>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-5 py-12 lg:px-8">
        <form method="POST" action="{{ route('checkout.store') }}" class="grid gap-16 lg:grid-cols-12">
            @csrf

            <div class="fade-up space-y-10 lg:col-span-7">
                <fieldset>
                    <legend class="font-serif text-2xl text-ink">Contact</legend>
                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="customer_name" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Full name</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required class="input-field">
                        </div>
                        <div>
                            <label for="customer_email" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Email</label>
                            <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" required class="input-field">
                        </div>
                        <div>
                            <label for="customer_phone" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Phone</label>
                            <input type="text" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" class="input-field">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="font-serif text-2xl text-ink">Shipping</legend>
                    <div class="mt-6 grid gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="shipping_address" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Address</label>
                            <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address', auth()->user()->address ?? '') }}" required class="input-field">
                        </div>
                        <div>
                            <label for="shipping_city" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">City</label>
                            <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', auth()->user()->city ?? '') }}" required class="input-field">
                        </div>
                        <div>
                            <label for="shipping_country" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Country</label>
                            <input type="text" name="shipping_country" id="shipping_country" value="{{ old('shipping_country', auth()->user()->country ?? '') }}" required class="input-field">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="shipping_postal" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Postal code</label>
                            <input type="text" name="shipping_postal" id="shipping_postal" value="{{ old('shipping_postal') }}" class="input-field sm:max-w-xs">
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="font-serif text-2xl text-ink">Payment</legend>
                    <div class="mt-6 space-y-4">
                        <label class="flex cursor-pointer items-start gap-4 border border-ink/10 p-4 transition hover:border-champagne">
                            <input type="radio" name="payment_method" value="cash_on_delivery" class="mt-1 accent-petrol" @checked(old('payment_method', 'cash_on_delivery') === 'cash_on_delivery')>
                            <span>
                                <span class="block text-[12px] uppercase tracking-[0.18em] text-ink">Cash on delivery</span>
                                <span class="mt-1 block text-sm text-ink/50">Pay when your order arrives.</span>
                            </span>
                        </label>
                        <label class="flex cursor-pointer items-start gap-4 border border-ink/10 p-4 transition hover:border-champagne">
                            <input type="radio" name="payment_method" value="bank_transfer" class="mt-1 accent-petrol" @checked(old('payment_method') === 'bank_transfer')>
                            <span>
                                <span class="block text-[12px] uppercase tracking-[0.18em] text-ink">Bank transfer</span>
                                <span class="mt-1 block text-sm text-ink/50">We will email transfer details after placing the order.</span>
                            </span>
                        </label>
                    </div>
                </fieldset>

                <div>
                    <label for="notes" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Order notes</label>
                    <textarea name="notes" id="notes" rows="3" class="input-field resize-y" placeholder="Optional delivery notes">{{ old('notes') }}</textarea>
                </div>
            </div>

            <aside class="reveal reveal-delay-1 lg:col-span-5">
                <div class="sticky top-28 border border-ink/10 bg-ink px-7 py-8 text-bone">
                    <p class="section-label text-champagne">Order summary</p>

                    <ul class="mt-8 space-y-5 border-b border-bone/15 pb-6">
                        @foreach($items as $item)
                            <li class="flex justify-between gap-4 text-sm">
                                <span class="text-bone/80">
                                    {{ $item['name'] }}
                                    <span class="text-bone/45">× {{ $item['quantity'] }}</span>
                                    @if(!empty($item['size']) || !empty($item['color']))
                                        <span class="mt-1 block text-[11px] uppercase tracking-[0.14em] text-bone/40">
                                            {{ collect([$item['size'] ?? null, $item['color'] ?? null])->filter()->implode(' · ') }}
                                        </span>
                                    @endif
                                </span>
                                <span class="shrink-0 tracking-[0.04em]">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-6 space-y-3 text-sm">
                        <div class="flex justify-between text-bone/60">
                            <span class="uppercase tracking-[0.16em] text-[11px]">Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-bone/60">
                            <span class="uppercase tracking-[0.16em] text-[11px]">Shipping</span>
                            <span>${{ number_format($shippingFee, 2) }}</span>
                        </div>
                        <div class="flex items-baseline justify-between border-t border-bone/15 pt-4">
                            <span class="uppercase tracking-[0.16em] text-[11px] text-champagne">Total</span>
                            <span class="font-serif text-3xl">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary mt-8 w-full bg-bone text-ink hover:bg-champagne">
                        Place order
                    </button>
                    <a href="{{ route('cart.index') }}" class="mt-4 block text-center text-[11px] uppercase tracking-[0.2em] text-bone/50 transition hover:text-champagne">
                        Return to bag
                    </a>
                </div>
            </aside>
        </form>
    </section>
@endsection
