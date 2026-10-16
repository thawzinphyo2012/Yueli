<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteName ?? 'Yueli Studio')</title>
    <meta name="description" content="@yield('meta_description', $siteTagline ?? 'A feminine editorial house of cloth, image, and quiet form.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Figtree:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body
    class="min-h-screen max-w-[100vw] overflow-x-hidden bg-porcelain text-ink font-sans"
    x-data="{ menuOpen: false }"
    @keydown.escape.window="menuOpen = false"
    :class="menuOpen ? 'overflow-hidden' : ''"
>
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[100] focus:bg-ink focus:px-4 focus:py-2 focus:text-porcelain">
        Skip to content
    </a>

    {{-- Magazine masthead --}}
    <header class="header-enter site-header sticky top-0 z-50 border-b border-ink/8 bg-porcelain/85 backdrop-blur-md">
        <div class="mx-auto max-w-[90rem] px-4 sm:px-5 lg:px-10">
            <div class="hidden items-center justify-between border-b border-ink/6 py-2.5 text-[9px] uppercase tracking-[0.28em] text-mist lg:flex">
                <span>Issue · Soft Structure</span>
                <span class="text-sky">Contemporary Atelier</span>
                <span>{{ now()->format('Y') }}</span>
            </div>

            <div class="flex items-center gap-3 py-3.5 sm:gap-4 sm:py-4 lg:gap-8 lg:py-5">
                <a href="{{ route('home') }}" class="masthead-brand max-w-[46vw] truncate sm:max-w-none">
                    {{ $siteName ?? 'Yueli Studio' }}
                </a>

                <div class="ml-auto flex items-center gap-2 sm:gap-3 lg:gap-6">
                    {{-- Desktop nav --}}
                    <nav class="hidden items-center gap-5 lg:flex lg:gap-6" aria-label="Primary">
                        <a href="{{ route('lookbook.index') }}" class="nav-link whitespace-nowrap text-ink {{ request()->routeIs('lookbook.*') ? 'nav-link-active' : '' }}">Lookbook</a>
                        <a href="{{ route('collections.index') }}" class="nav-link whitespace-nowrap text-ink {{ request()->routeIs('collections.*') ? 'nav-link-active' : '' }}">Collections</a>
                        <a href="{{ route('shop.index') }}" class="nav-link whitespace-nowrap text-ink {{ request()->routeIs('shop.*') ? 'nav-link-active' : '' }}">Shop</a>
                        <a href="{{ route('about') }}" class="nav-link whitespace-nowrap text-ink {{ request()->routeIs('about') ? 'nav-link-active' : '' }}">About</a>
                        <a href="{{ route('contact') }}" class="nav-link whitespace-nowrap text-ink {{ request()->routeIs('contact') ? 'nav-link-active' : '' }}">Contact</a>
                    </nav>

                    <a href="{{ route('cart.index') }}" class="bag-pill relative min-h-11 min-w-11 justify-center" aria-label="Shopping bag">
                        <i data-lucide="shopping-bag" class="h-4 w-4"></i>
                        <span class="hidden sm:inline">Bag</span>
                        @if(($cartCount ?? 0) > 0)
                            <span class="flex h-4 min-w-4 items-center justify-center rounded-full bg-rose px-1 text-[9px] font-medium text-porcelain">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden text-[10px] uppercase tracking-[0.22em] text-ink transition hover:text-rose lg:inline">Admin</a>
                        @endif
                    @endauth

                    {{-- Mobile menu toggle --}}
                    <button
                        type="button"
                        class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-ink/10 bg-porcelain text-ink transition hover:border-primary/40 hover:text-primary lg:hidden"
                        @click="menuOpen = !menuOpen"
                        :aria-expanded="menuOpen.toString()"
                        aria-controls="mobile-nav"
                        aria-label="Toggle menu"
                    >
                        <svg x-show="!menuOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4" aria-hidden="true"><path d="M4 5h16M4 12h16M4 19h16"/></svg>
                        <svg x-cloak x-show="menuOpen" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile drawer --}}
        <div
            id="mobile-nav"
            class="border-t border-ink/8 bg-porcelain lg:hidden"
            x-cloak
            x-show="menuOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
        >
            <nav class="mx-auto flex max-w-[90rem] flex-col px-4 py-3 sm:px-5" aria-label="Mobile">
                @foreach([
                    ['lookbook.index', 'lookbook.*', 'Lookbook'],
                    ['collections.index', 'collections.*', 'Collections'],
                    ['shop.index', 'shop.*', 'Shop'],
                    ['about', 'about', 'About'],
                    ['contact', 'contact', 'Contact'],
                ] as [$route, $active, $label])
                    <a
                        href="{{ route($route) }}"
                        class="flex min-h-12 items-center border-b border-ink/6 py-3 text-[12px] uppercase tracking-[0.22em] transition hover:text-primary {{ request()->routeIs($active) ? 'text-primary' : 'text-ink' }}"
                        @click="menuOpen = false"
                    >
                        {{ $label }}
                    </a>
                @endforeach

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex min-h-12 items-center py-3 text-[12px] uppercase tracking-[0.22em] text-mist hover:text-primary" @click="menuOpen = false">
                            Admin
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    @if(session('success') || session('error') || $errors->any())
        <div class="mx-auto max-w-[90rem] px-4 pt-4 sm:px-5 lg:px-10">
            @if(session('success'))
                <div class="border border-rose/30 bg-blush px-4 py-3 text-sm text-plum" role="status">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mt-2 border border-ink/15 bg-blush/50 px-4 py-3 text-sm text-ink" role="alert">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="mt-2 border border-ink/15 bg-blush/50 px-4 py-3 text-sm text-ink" role="alert">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <main id="main" class="overflow-x-hidden">
        @yield('content')
    </main>

    <footer class="footer-glow mt-16 border-t border-porcelain/10 text-porcelain sm:mt-24 lg:mt-28">
        <div class="mx-auto max-w-[90rem] px-4 py-14 sm:px-5 sm:py-20 lg:px-10">
            <div class="ornament mb-10 sm:mb-12">
                <span class="ornament-mark">✦</span>
            </div>
            <div class="grid gap-10 sm:gap-14 md:grid-cols-12">
                <div class="space-y-5 md:col-span-5">
                    <p class="font-display text-3xl italic tracking-[0.02em] sm:text-4xl">{{ $siteName ?? 'Yueli Studio' }}</p>
                    <div class="editorial-rule bg-rose"></div>
                    <p class="max-w-sm font-serif text-lg leading-relaxed text-porcelain/65 sm:text-xl">
                        {{ $siteTagline ?? 'A feminine editorial house of cloth, image, and quiet form.' }}
                    </p>
                </div>

                <div class="md:col-span-3">
                    <p class="section-label mb-5 text-rose sm:mb-6">Journal</p>
                    <ul class="space-y-3 text-[11px] uppercase tracking-[0.18em] text-porcelain/60">
                        <li><a href="{{ route('lookbook.index') }}" class="inline-flex min-h-10 items-center hover:text-rose">Lookbook</a></li>
                        <li><a href="{{ route('collections.index') }}" class="inline-flex min-h-10 items-center hover:text-rose">Collections</a></li>
                        <li><a href="{{ route('shop.index') }}" class="inline-flex min-h-10 items-center hover:text-rose">Shop</a></li>
                        <li><a href="{{ route('about') }}" class="inline-flex min-h-10 items-center hover:text-rose">About</a></li>
                        <li><a href="{{ route('contact') }}" class="inline-flex min-h-10 items-center hover:text-rose">Contact</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4">
                    <p class="section-label mb-5 text-rose sm:mb-6">Atelier</p>
                    <ul class="space-y-4 text-sm text-porcelain/65">
                        <li><a href="mailto:studio@yuelistudio.com" class="hover:text-rose">studio@yuelistudio.com</a></li>
                        <li>By appointment · Yangon & beyond</li>
                        <li class="pt-2">
                            <a href="{{ route('shop.index') }}" class="btn-outline border-porcelain/25 text-[10px]">Shop the edit</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-porcelain/10">
            <div class="mx-auto flex max-w-[90rem] flex-col gap-2 px-4 py-6 text-[10px] uppercase tracking-[0.2em] text-porcelain/40 sm:flex-row sm:justify-between sm:px-5 lg:px-10">
                <p>&copy; {{ date('Y') }} {{ $siteName ?? 'Yueli Studio' }}</p>
                <p>Magazine · Portfolio · Boutique</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
