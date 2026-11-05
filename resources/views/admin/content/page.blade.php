@extends('layouts.admin')

@section('title', $pageMeta['label'].' — Pages')
@section('heading', $pageMeta['label'])

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.content.index') }}" class="text-xs text-[var(--mist)] hover:text-[var(--accent)]">← All pages</a>
            <h1 class="font-display text-2xl font-bold tracking-tight mt-1">{{ $pageMeta['label'] }}</h1>
            <p class="text-sm text-[var(--mist)] mt-1">{{ $pageMeta['description'] }}</p>
        </div>
        <a href="{{ route('admin.content.create', ['page' => $pageKey]) }}" class="admin-btn">
            <i data-lucide="plus" class="w-4 h-4"></i> Add section
        </a>
    </div>

    <div class="space-y-3">
        @foreach ($sections as $section)
            @php $block = $section['block']; @endphp
            <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-4 sm:p-5">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <div class="h-24 w-full shrink-0 overflow-hidden rounded-xl bg-[var(--slate)] sm:h-28 sm:w-24">
                        @if ($block?->imageUrl())
                            <img src="{{ $block->imageUrl() }}" alt="" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-[var(--mist)]">
                                <i data-lucide="image" class="h-6 w-6"></i>
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-display text-lg font-bold">{{ $section['label'] }}</h2>
                            @if ($block?->is_active)
                                <span class="rounded-full bg-[color-mix(in_srgb,var(--ok)_18%,transparent)] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-[var(--ok)]">Active</span>
                            @else
                                <span class="rounded-full bg-[var(--slate)] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-[var(--mist)]">Hidden</span>
                            @endif
                        </div>
                        <p class="mt-1 font-mono text-[11px] text-[var(--mist)]">{{ $section['key'] }}</p>
                        <p class="mt-2 line-clamp-2 text-sm text-[var(--paper)]">
                            {{ $block?->title ?: 'No title yet' }}
                            @if ($block?->body)
                                — {{ \Illuminate\Support\Str::limit(strip_tags($block->body), 90) }}
                            @endif
                        </p>
                    </div>

                    <div class="flex shrink-0 gap-2 sm:flex-col">
                        @if ($block)
                            <a href="{{ route('admin.content.edit', $block) }}" class="admin-btn">
                                <i data-lucide="pencil" class="h-3.5 w-3.5"></i> Edit text & photo
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
