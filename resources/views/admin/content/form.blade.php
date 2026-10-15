@extends('layouts.admin')

@section('title', $block->exists ? 'Edit content' : 'New content')
@section('heading', $block->exists ? 'Edit content' : 'New content')

@section('content')
<div class="max-w-3xl space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">
                {{ $block->exists ? 'Edit content block' : 'New content block' }}
            </h1>
            <p class="text-sm text-[var(--mist)] mt-1">
                {{ $block->exists ? $block->key : 'Create a page content block' }}
            </p>
        </div>
        <a href="{{ route('admin.content.index') }}" class="admin-btn admin-btn-ghost">Back</a>
    </div>

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
                <label class="admin-label" for="key">Key</label>
                <input id="key" name="key" type="text" class="admin-input" value="{{ old('key', $block->key) }}" required>
            </div>

            <div>
                <label class="admin-label" for="page">Page</label>
                <input id="page" name="page" type="text" class="admin-input" value="{{ old('page', $block->page) }}" required placeholder="home, about…">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="title">Title</label>
                <input id="title" name="title" type="text" class="admin-input" value="{{ old('title', $block->title) }}">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="subtitle">Subtitle</label>
                <input id="subtitle" name="subtitle" type="text" class="admin-input" value="{{ old('subtitle', $block->subtitle) }}">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="body">Body</label>
                <textarea id="body" name="body" rows="6" class="admin-input">{{ old('body', $block->body) }}</textarea>
            </div>

            <div>
                <label class="admin-label" for="cta_label">CTA label</label>
                <input id="cta_label" name="cta_label" type="text" class="admin-input" value="{{ old('cta_label', $block->cta_label) }}">
            </div>

            <div>
                <label class="admin-label" for="cta_url">CTA URL</label>
                <input id="cta_url" name="cta_url" type="text" class="admin-input" value="{{ old('cta_url', $block->cta_url) }}">
            </div>

            <div>
                <label class="admin-label" for="sort_order">Sort order</label>
                <input id="sort_order" name="sort_order" type="number" min="0" class="admin-input" value="{{ old('sort_order', $block->sort_order ?? 0) }}">
            </div>

            <div class="flex items-end pb-1">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-[var(--edge)]" @checked(old('is_active', $block->is_active ?? true))>
                    Active
                </label>
            </div>

            <div>
                <label class="admin-label" for="image">Image</label>
                <input id="image" name="image" type="file" accept="image/*" class="admin-input">
                @if ($block->image)
                    <p class="text-xs text-[var(--mist)] mt-1 truncate">Current: {{ $block->image }}</p>
                @endif
            </div>

            <div>
                <label class="admin-label" for="image_url">Or image URL</label>
                <input id="image_url" name="image_url" type="url" class="admin-input" value="{{ old('image_url') }}" placeholder="https://…">
            </div>
        </div>

        <div class="flex gap-3 pt-2 border-t border-[var(--edge)]">
            <button type="submit" class="admin-btn">
                {{ $block->exists ? 'Update block' : 'Create block' }}
            </button>
            <a href="{{ route('admin.content.index') }}" class="admin-btn admin-btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
