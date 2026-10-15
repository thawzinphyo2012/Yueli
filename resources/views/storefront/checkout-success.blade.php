@extends('layouts.storefront')

@section('title', 'Order confirmed — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="mx-auto max-w-3xl px-5 py-24 text-center lg:px-8 lg:py-32">
        <div class="fade-up mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-petrol/10 text-petrol">
            <i data-lucide="check" class="h-6 w-6"></i>
        </div>

        <p class="fade-up reveal-delay-1 mt-8 section-label">Thank you</p>
        <h1 class="fade-up reveal-delay-2 mt-4 font-serif text-5xl text-ink">Order confirmed</h1>
        <p class="fade-up reveal-delay-3 mt-5 font-serif text-xl leading-relaxed text-ink/65">
            We’ve received your order and will be in touch shortly with next steps.
        </p>

        <div class="reveal reveal-delay-4 mt-12 border border-ink/10 px-8 py-10 text-left">
            <div class="flex flex-col gap-6 sm:flex-row sm:justify-between">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-ink/40">Order number</p>
                    <p class="mt-2 font-serif text-2xl text-ink">{{ $order->order_number }}</p>
                </div>
                <div class="sm:text-right">
                    <p class="text-[11px] uppercase tracking-[0.2em] text-ink/40">Total</p>
                    <p class="mt-2 font-serif text-2xl text-ink">${{ number_format($order->total, 2) }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 border-t border-ink/10 pt-8 sm:grid-cols-2">
                <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-ink/40">Ship to</p>
                    <p class="mt-2 text-sm leading-relaxed text-ink/70">
                        {{ $order->customer_name }}<br>
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}{{ $order->shipping_postal ? ', '.$order->shipping_postal : '' }}<br>
                        {{ $order->shipping_country }}
                    </p>
                </div>
                <div>
                    <p class="text-[11px] uppercase tracking-[0.2em] text-ink/40">Payment</p>
                    <p class="mt-2 text-sm text-ink/70">
                        {{ str_replace('_', ' ', ucfirst($order->payment_method)) }}
                    </p>
                    <p class="mt-1 text-sm text-ink/50">Status · {{ ucfirst($order->status) }}</p>
                </div>
            </div>

            @if($order->items->isNotEmpty())
                <ul class="mt-8 space-y-3 border-t border-ink/10 pt-8">
                    @foreach($order->items as $item)
                        <li class="flex justify-between gap-4 text-sm text-ink/70">
                            <span>
                                {{ $item->product_name }} × {{ $item->quantity }}
                                @if($item->size || $item->color)
                                    <span class="block text-[11px] uppercase tracking-[0.14em] text-ink/40">
                                        {{ collect([$item->size, $item->color])->filter()->implode(' · ') }}
                                    </span>
                                @endif
                            </span>
                            <span>${{ number_format($item->line_total, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="fade-up mt-12 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('shop.index') }}" class="btn-primary">Continue shopping</a>
            <a href="{{ route('home') }}" class="btn-ghost">Back to home</a>
        </div>
    </section>
@endsection
