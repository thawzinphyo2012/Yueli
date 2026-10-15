@extends('layouts.admin')

@section('title', $project->exists ? 'Edit project' : 'New project')
@section('heading', $project->exists ? 'Edit project' : 'New project')

@section('content')
<div class="max-w-3xl space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">
                {{ $project->exists ? 'Edit project' : 'New project' }}
            </h1>
            <p class="text-sm text-[var(--mist)] mt-1">
                {{ $project->exists ? $project->title : 'Create a portfolio project' }}
            </p>
        </div>
        <a href="{{ route('admin.portfolio.index') }}" class="admin-btn admin-btn-ghost">Back</a>
    </div>

    <form
        method="POST"
        action="{{ $project->exists ? route('admin.portfolio.update', $project) : route('admin.portfolio.store') }}"
        enctype="multipart/form-data"
        class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-5 space-y-5"
    >
        @csrf
        @if ($project->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="admin-label" for="title">Title</label>
                <input id="title" name="title" type="text" class="admin-input" value="{{ old('title', $project->title) }}" required>
            </div>

            <div>
                <label class="admin-label" for="client">Client</label>
                <input id="client" name="client" type="text" class="admin-input" value="{{ old('client', $project->client) }}">
            </div>

            <div>
                <label class="admin-label" for="role">Role</label>
                <input id="role" name="role" type="text" class="admin-input" value="{{ old('role', $project->role) }}">
            </div>

            <div>
                <label class="admin-label" for="year">Year</label>
                <input id="year" name="year" type="text" class="admin-input" value="{{ old('year', $project->year) }}">
            </div>

            <div>
                <label class="admin-label" for="sort_order">Sort order</label>
                <input id="sort_order" name="sort_order" type="number" min="0" class="admin-input" value="{{ old('sort_order', $project->sort_order ?? 0) }}">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="2" class="admin-input">{{ old('excerpt', $project->excerpt) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="body">Body</label>
                <textarea id="body" name="body" rows="6" class="admin-input">{{ old('body', $project->body) }}</textarea>
            </div>

            <div>
                <label class="admin-label" for="cover_image">Cover image</label>
                <input id="cover_image" name="cover_image" type="file" accept="image/*" class="admin-input">
                @if ($project->cover_image)
                    <p class="text-xs text-[var(--mist)] mt-1 truncate">Current: {{ $project->cover_image }}</p>
                @endif
            </div>

            <div>
                <label class="admin-label" for="image_url">Or image URL</label>
                <input id="image_url" name="image_url" type="url" class="admin-input" value="{{ old('image_url') }}" placeholder="https://…">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="gallery_urls">Gallery URLs (one per line)</label>
                <textarea id="gallery_urls" name="gallery_urls" rows="5" class="admin-input" placeholder="https://…">{{ old('gallery_urls', is_array($project->gallery) ? implode("\n", $project->gallery) : '') }}</textarea>
            </div>

            <div class="sm:col-span-2 flex flex-wrap gap-6 pt-1">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-[var(--edge)]" @checked(old('is_featured', $project->is_featured))>
                    Featured
                </label>
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-[var(--edge)]" @checked(old('is_published', $project->is_published))>
                    Published
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2 border-t border-[var(--edge)]">
            <button type="submit" class="admin-btn">
                {{ $project->exists ? 'Update project' : 'Create project' }}
            </button>
            <a href="{{ route('admin.portfolio.index') }}" class="admin-btn admin-btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
