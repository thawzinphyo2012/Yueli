@extends('layouts.admin')

@section('title', $product->exists ? 'Edit product' : 'New product')
@section('heading', $product->exists ? 'Edit product' : 'New product')

@section('content')
<div class="max-w-3xl space-y-4">
    <div class="flex items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">
                {{ $product->exists ? 'Edit product' : 'New product' }}
            </h1>
            <p class="text-sm text-[var(--mist)] mt-1">
                {{ $product->exists ? $product->name : 'Create a catalog item' }}
            </p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-ghost">Back</a>
    </div>

    <form
        method="POST"
        action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
        enctype="multipart/form-data"
        class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg p-5 space-y-5"
    >
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="admin-label" for="name">Name</label>
                <input id="name" name="name" type="text" class="admin-input" value="{{ old('name', $product->name) }}" required>
            </div>

            <div>
                <label class="admin-label" for="sku">SKU</label>
                <input id="sku" name="sku" type="text" class="admin-input" value="{{ old('sku', $product->sku) }}">
            </div>

            <div>
                <label class="admin-label" for="collection_id">Collection</label>
                <select id="collection_id" name="collection_id" class="admin-input">
                    <option value="">— None —</option>
                    @foreach ($collections as $collection)
                        <option value="{{ $collection->id }}" @selected(old('collection_id', $product->collection_id) == $collection->id)>
                            {{ $collection->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="admin-label" for="price">Price</label>
                <input id="price" name="price" type="number" step="0.01" min="0" class="admin-input" value="{{ old('price', $product->price) }}" required>
            </div>

            <div>
                <label class="admin-label" for="compare_at_price">Compare at price</label>
                <input id="compare_at_price" name="compare_at_price" type="number" step="0.01" min="0" class="admin-input" value="{{ old('compare_at_price', $product->compare_at_price) }}">
            </div>

            <div>
                <label class="admin-label" for="stock">Stock</label>
                <input id="stock" name="stock" type="number" min="0" class="admin-input" value="{{ old('stock', $product->stock ?? 0) }}" required>
            </div>

            <div>
                <label class="admin-label" for="sizes">Sizes (comma-separated)</label>
                <input id="sizes" name="sizes" type="text" class="admin-input" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : $product->sizes) }}" placeholder="XS, S, M, L">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="colors">Colors (comma-separated)</label>
                <input id="colors" name="colors" type="text" class="admin-input" value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : $product->colors) }}" placeholder="Black, Ivory">
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="short_description">Short description</label>
                <textarea id="short_description" name="short_description" rows="2" class="admin-input">{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="admin-label" for="description">Description</label>
                <textarea id="description" name="description" rows="6" class="admin-input">{{ old('description', $product->description) }}</textarea>
            </div>

            <div>
                <label class="admin-label" for="primary_image">Primary image</label>
                <input id="primary_image" name="primary_image" type="file" accept="image/*" class="admin-input">
                @if ($product->primary_image)
                    <p class="text-xs text-[var(--mist)] mt-1 truncate">Current: {{ $product->primary_image }}</p>
                @endif
            </div>

            <div>
                <label class="admin-label" for="image_url">Or image URL</label>
                <input id="image_url" name="image_url" type="url" class="admin-input" value="{{ old('image_url') }}" placeholder="https://…">
            </div>

            <div class="sm:col-span-2 flex flex-wrap gap-6 pt-1">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-[var(--edge)]" @checked(old('is_featured', $product->is_featured))>
                    Featured
                </label>
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-[var(--edge)]" @checked(old('is_published', $product->is_published))>
                    Published
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2 border-t border-[var(--edge)]">
            <button type="submit" class="admin-btn">
                {{ $product->exists ? 'Update product' : 'Create product' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="admin-btn admin-btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection
