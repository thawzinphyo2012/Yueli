@extends('layouts.admin')

@section('title', $block->exists ? 'Edit section' : 'New section')
@section('heading', $block->exists ? 'Edit section' : 'New section')

@section('content')
@php
    $sectionTitle = $block->exists ? $block->sectionLabel() : 'New section';
    $returnPage = old('page', $block->page ?: 'home');
@endphp
<div class="max-w-3xl space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.content.page', $returnPage) }}" class="text-xs text-[var(--mist)] hover:text-[var(--accent)]">← Back to page</a>
            <h1 class="font-display text-2xl font-bold tracking-tight mt-1">
                {{ $block->exists ? 'Edit: '.$sectionTitle : 'New section' }}
            </h1>
            <p class="text-sm text-[var(--mist)] mt-1">Change copy and replace the photo for this section</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="rounded-lg border border-[var(--danger)]/40 bg-[color-mix(in_srgb,var(--danger)_12%,transparent)] px-4 py-3 text-sm text-[var(--danger)]">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ $block->exists ? route('admin.content.update', $block) : route('admin.content.store') }}"
        enctype="multipart/form-data"
        class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-5 space-y-5"
    >
        @csrf
        @if ($block->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="admin-label" for="page">Page</label>
                <select id="page" name="page" class="admin-input" required>
                    @foreach ($pages as $key => $meta)
                        <option value="{{ $key }}" @selected(old('page', $block->page) === $key)>{{ $meta['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="admin-label" for="key">Section key</label>
                <input
                    id="key"
                    name="key"
                    type="text"
                    class="admin-input font-mono text-xs"
                    value="{{ old('key', $block->key) }}"
                    required
                    @readonly($block->exists)
                >
                @if ($block->exists)
                    <p class="mt-1 text-[11px] text-[var(--mist)]">Key is locked so the website keeps finding this section.</p>
                @endif
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="title">Headline</label>
                <input id="title" name="title" type="text" class="admin-input" value="{{ old('title', $block->title) }}" placeholder="Main hero headline">
            </div>

            <div>
                <label class="admin-label" for="subtitle">Season / subtitle</label>
                <input id="subtitle" name="subtitle" type="text" class="admin-input" value="{{ old('subtitle', $block->subtitle) }}" placeholder="Season 26">
            </div>

            <div>
                <label class="admin-label" for="eyebrow">Eyebrow tag</label>
                <input id="eyebrow" name="eyebrow" type="text" class="admin-input" value="{{ old('eyebrow', $block->eyebrow) }}" placeholder="Contemporary Atelier">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="body">Supporting text</label>
                <textarea id="body" name="body" rows="7" class="admin-input">{{ old('body', $block->body) }}</textarea>
            </div>

            <div>
                <label class="admin-label" for="cta_label">Primary button</label>
                <input id="cta_label" name="cta_label" type="text" class="admin-input" value="{{ old('cta_label', $block->cta_label) }}">
            </div>

            <div>
                <label class="admin-label" for="cta_url">Primary link</label>
                <input id="cta_url" name="cta_url" type="text" class="admin-input" value="{{ old('cta_url', $block->cta_url) }}" placeholder="/shop">
            </div>

            <div>
                <label class="admin-label" for="cta2_label">Secondary button</label>
                <input id="cta2_label" name="cta2_label" type="text" class="admin-input" value="{{ old('cta2_label', $block->cta2_label) }}">
            </div>

            <div>
                <label class="admin-label" for="cta2_url">Secondary link</label>
                <input id="cta2_url" name="cta2_url" type="text" class="admin-input" value="{{ old('cta2_url', $block->cta2_url) }}" placeholder="/lookbook">
            </div>

            <div>
                <label class="admin-label" for="sort_order">Sort order</label>
                <input id="sort_order" name="sort_order" type="number" min="0" class="admin-input" value="{{ old('sort_order', $block->sort_order ?? 0) }}">
            </div>

            <div class="flex items-end pb-1">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-[var(--edge)]" @checked(old('is_active', $block->is_active ?? true))>
                    Show on website
                </label>
            </div>
        </div>

        <div class="rounded-xl border border-[var(--edge)] bg-[var(--slate)]/40 p-4 space-y-4">
            <div>
                <p class="admin-label mb-0">Photo</p>
                <p class="text-xs text-[var(--mist)] mt-1">Upload a new file or paste an image URL. Leave empty to keep the current photo.</p>
            </div>

            @if ($block->imageUrl())
                <div class="overflow-hidden rounded-xl border border-[var(--edge)] bg-[var(--graphite)] max-w-sm">
                    <img src="{{ $block->imageUrl() }}" alt="Current" class="max-h-64 w-full object-cover object-[center_20%]">
                </div>
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer text-[var(--danger)]">
                    <input type="checkbox" name="remove_image" value="1" class="rounded border-[var(--edge)]">
                    Remove current photo
                </label>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="admin-label" for="image">Upload image</label>
                    <input id="image" name="image" type="file" accept="image/*" class="admin-input">
                </div>
                <div>
                    <label class="admin-label" for="image_url">Or image URL</label>
                    <input id="image_url" name="image_url" type="url" class="admin-input" value="{{ old('image_url') }}" placeholder="https://…">
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 pt-2 border-t border-[var(--edge)]">
            <button type="submit" class="admin-btn">
                {{ $block->exists ? 'Save text & photo' : 'Create section' }}
            </button>
            <a href="{{ route('admin.content.page', $returnPage) }}" class="admin-btn admin-btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
