@extends('layouts.admin')

@section('title', $collection->exists ? 'Edit collection' : 'New collection')
@section('heading', $collection->exists ? 'Edit collection' : 'New collection')

@section('content')
<div class="max-w-3xl space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">
                {{ $collection->exists ? 'Edit collection' : 'New collection' }}
            </h1>
            <p class="text-sm text-[var(--mist)] mt-1">
                {{ $collection->exists ? $collection->name : 'Create a collection' }}
            </p>
        </div>
        <a href="{{ route('admin.collections.index') }}" class="admin-btn admin-btn-ghost">Back</a>
    </div>

    <form
        method="POST"
        action="{{ $collection->exists ? route('admin.collections.update', $collection) : route('admin.collections.store') }}"
        enctype="multipart/form-data"
        class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-5 space-y-5"
    >
        @csrf
        @if ($collection->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="admin-label" for="name">Name</label>
                <input id="name" name="name" type="text" class="admin-input" value="{{ old('name', $collection->name) }}" required>
            </div>

            <div>
                <label class="admin-label" for="season">Season</label>
                <input id="season" name="season" type="text" class="admin-input" value="{{ old('season', $collection->season) }}" placeholder="SS26">
            </div>

            <div>
                <label class="admin-label" for="sort_order">Sort order</label>
                <input id="sort_order" name="sort_order" type="number" min="0" class="admin-input" value="{{ old('sort_order', $collection->sort_order ?? 0) }}">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="description">Description</label>
                <textarea id="description" name="description" rows="5" class="admin-input">{{ old('description', $collection->description) }}</textarea>
            </div>

            <div>
                <label class="admin-label" for="cover_image">Cover image</label>
                <input id="cover_image" name="cover_image" type="file" accept="image/*" class="admin-input">
                @if ($collection->cover_image)
                    <p class="text-xs text-[var(--mist)] mt-1 truncate">Current: {{ $collection->cover_image }}</p>
                @endif
            </div>

            <div>
                <label class="admin-label" for="image_url">Or image URL</label>
                <input id="image_url" name="image_url" type="url" class="admin-input" value="{{ old('image_url') }}" placeholder="https://…">
            </div>

            <div class="sm:col-span-2 flex flex-wrap gap-6 pt-1">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-[var(--edge)]" @checked(old('is_featured', $collection->is_featured))>
                    Featured
                </label>
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-[var(--edge)]" @checked(old('is_published', $collection->is_published))>
                    Published
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2 border-t border-[var(--edge)]">
            <button type="submit" class="admin-btn">
                {{ $collection->exists ? 'Update collection' : 'Create collection' }}
            </button>
            <a href="{{ route('admin.collections.index') }}" class="admin-btn admin-btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
