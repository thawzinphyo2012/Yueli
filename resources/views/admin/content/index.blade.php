@extends('layouts.admin')

@section('title', 'Pages')
@section('heading', 'Pages')

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">Pages</h1>
            <p class="text-sm text-[var(--mist)] mt-1">
                Edit each storefront page — titles, copy, and images
            </p>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($pages as $page)
            <a
                href="{{ route('admin.content.page', $page['key']) }}"
                class="group block bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-5 transition hover:border-[var(--accent)]"
            >
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.18em] text-[var(--mist)]">Page</p>
                        <h2 class="mt-1 font-display text-xl font-bold group-hover:text-[var(--accent)]">
                            {{ $page['label'] }}
                        </h2>
                    </div>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[var(--slate)] text-[var(--mist)] group-hover:bg-[var(--accent)] group-hover:text-white">
                        <i data-lucide="pencil" class="h-4 w-4"></i>
                    </span>
                </div>
                <p class="mt-3 text-sm leading-relaxed text-[var(--mist)]">{{ $page['description'] }}</p>
                <p class="mt-4 text-xs text-[var(--mist)]">
                    {{ $page['sections'] }} editable section{{ $page['sections'] === 1 ? '' : 's' }}
                </p>
            </a>
        @endforeach
    </div>
</div>
@endsection
