@extends('layouts.storefront')

@section('title', 'Login — '.($siteName ?? 'Yueli Studio'))

@section('content')
    <section class="mx-auto grid min-h-[70vh] max-w-7xl items-center gap-0 px-5 py-16 lg:grid-cols-2 lg:px-8 lg:py-24">
        <div class="fade-up relative hidden overflow-hidden bg-ink text-bone lg:flex lg:min-h-[560px] lg:flex-col lg:justify-end lg:p-12">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_70%_20%,#1F3D3A_0%,transparent_50%),linear-gradient(165deg,#0B0C0B_0%,#1F3D3A_100%)]"></div>
            <div class="relative z-10">
                <p class="section-label text-champagne">{{ $siteName ?? 'Yueli Studio' }}</p>
                <h1 class="mt-4 font-serif text-5xl leading-tight">Quiet access to the atelier</h1>
                <p class="mt-5 max-w-sm font-serif text-lg text-bone/65">
                    {{ $siteTagline ?? 'Editorial clothing for modern quiet luxury.' }}
                </p>
            </div>
        </div>

        <div class="reveal reveal-delay-1 flex items-center justify-center lg:px-16">
            <div class="w-full max-w-md">
                <p class="section-label lg:hidden">Account</p>
                <h1 class="mt-3 font-serif text-4xl text-ink lg:mt-0">Sign in</h1>
                <p class="mt-3 font-serif text-lg text-ink/55">Enter your credentials to continue.</p>

                <form method="POST" action="{{ route('login') }}" class="mt-10 space-y-7">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="input-field @error('email') border-ink @enderror"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-ink/70">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-[11px] uppercase tracking-[0.2em] text-ink/45">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="input-field"
                        >
                    </div>

                    <label class="flex items-center gap-3 text-sm text-ink/60">
                        <input type="checkbox" name="remember" class="accent-petrol" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>

                    <button type="submit" class="btn-primary w-full">
                        Sign in
                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                    </button>
                </form>

                <p class="mt-8 text-center text-sm text-ink/45">
                    <a href="{{ route('home') }}" class="transition hover:text-champagne">Return to storefront</a>
                </p>
            </div>
        </div>
    </section>
@endsection
