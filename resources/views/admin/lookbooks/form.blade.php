@extends('layouts.admin')

@section('title', $lookbook->exists ? 'Edit lookbook' : 'New lookbook')
@section('heading', $lookbook->exists ? 'Edit lookbook' : 'New lookbook')

@section('content')
<div class="max-w-3xl space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">
                {{ $lookbook->exists ? 'Edit lookbook' : 'New lookbook' }}
            </h1>
            <p class="text-sm text-[var(--mist)] mt-1">
                {{ $lookbook->exists ? $lookbook->title : 'Create a lookbook' }}
            </p>
        </div>
        <a href="{{ route('admin.lookbooks.index') }}" class="admin-btn admin-btn-ghost">Back</a>
    </div>

    <form
        method="POST"
        action="{{ $lookbook->exists ? route('admin.lookbooks.update', $lookbook) : route('admin.lookbooks.store') }}"
        enctype="multipart/form-data"
        class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-5 space-y-5"
    >
        @csrf
        @if ($lookbook->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="admin-label" for="title">Title</label>
                <input id="title" name="title" type="text" class="admin-input" value="{{ old('title', $lookbook->title) }}" required>
            </div>

            <div>
                <label class="admin-label" for="collection_id">Collection</label>
                <select id="collection_id" name="collection_id" class="admin-input">
                    <option value="">— None —</option>
                    @foreach ($collections as $collection)
                        <option value="{{ $collection->id }}" @selected(old('collection_id', $lookbook->collection_id) == $collection->id)>
                            {{ $collection->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="admin-label" for="sort_order">Sort order</label>
                <input id="sort_order" name="sort_order" type="number" min="0" class="admin-input" value="{{ old('sort_order', $lookbook->sort_order ?? 0) }}">
            </div>

            <div>
                <label class="admin-label" for="photographer">Photographer</label>
                <input id="photographer" name="photographer" type="text" class="admin-input" value="{{ old('photographer', $lookbook->photographer) }}">
            </div>

            <div>
                <label class="admin-label" for="location">Location</label>
                <input id="location" name="location" type="text" class="admin-input" value="{{ old('location', $lookbook->location) }}">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="description">Description</label>
                <textarea id="description" name="description" rows="4" class="admin-input">{{ old('description', $lookbook->description) }}</textarea>
            </div>

            <div>
                <label class="admin-label" for="cover_image">Cover image</label>
                <input id="cover_image" name="cover_image" type="file" accept="image/*" class="admin-input">
                @if ($lookbook->cover_image)
                    <p class="text-xs text-[var(--mist)] mt-1 truncate">Current: {{ $lookbook->cover_image }}</p>
                @endif
            </div>

            <div>
                <label class="admin-label" for="image_url">Or image URL</label>
                <input id="image_url" name="image_url" type="url" class="admin-input" value="{{ old('image_url') }}" placeholder="https://…">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="gallery_urls">Gallery URLs (one per line)</label>
                <textarea id="gallery_urls" name="gallery_urls" rows="5" class="admin-input" placeholder="https://…">{{ old('gallery_urls', is_array($lookbook->images) ? implode("\n", $lookbook->images) : '') }}</textarea>
            </div>

            <div class="sm:col-span-2 flex flex-wrap gap-6 pt-1">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_campaign" value="1" class="rounded border-[var(--edge)]" @checked(old('is_campaign', $lookbook->is_campaign))>
                    Campaign
                </label>
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-[var(--edge)]" @checked(old('is_published', $lookbook->is_published))>
                    Published
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2 border-t border-[var(--edge)]">
            <button type="submit" class="admin-btn">
                {{ $lookbook->exists ? 'Update lookbook' : 'Create lookbook' }}
            </button>
            <a href="{{ route('admin.lookbooks.index') }}" class="admin-btn admin-btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
