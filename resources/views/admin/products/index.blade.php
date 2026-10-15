@extends('layouts.admin')

@section('title', 'Products')
@section('heading', 'Products')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">Products</h1>
            <p class="text-sm text-[var(--mist)] mt-1">Catalog inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="admin-btn">
            <i data-lucide="plus" class="w-4 h-4"></i> Add product
        </a>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Collection</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="font-semibold">{{ $product->name }}</td>
                            <td class="text-[var(--mist)]">{{ $product->sku ?: '—' }}</td>
                            <td>{{ $product->collection?->name ?? '—' }}</td>
                            <td>${{ number_format((float) $product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if ($product->is_published)
                                    <span class="text-[var(--ok)]">Published</span>
                                @else
                                    <span class="text-[var(--mist)]">Draft</span>
                                @endif
                                @if ($product->is_featured)
                                    <span class="text-[var(--accent)] ml-1">· Featured</span>
                                @endif
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-xs text-[var(--accent)] hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-[var(--danger)] hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-[var(--mist)] py-8">No products yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $products->links() }}</div>
</div>
@endsection
