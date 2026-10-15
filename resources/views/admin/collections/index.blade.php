@extends('layouts.admin')

@section('title', 'Collections')
@section('heading', 'Collections')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">Collections</h1>
            <p class="text-sm text-[var(--mist)] mt-1">Seasonal groupings</p>
        </div>
        <a href="{{ route('admin.collections.create') }}" class="admin-btn">
            <i data-lucide="plus" class="w-4 h-4"></i> Add collection
        </a>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Season</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collections as $collection)
                        <tr>
                            <td class="font-semibold">{{ $collection->name }}</td>
                            <td>{{ $collection->season ?: '—' }}</td>
                            <td>{{ $collection->sort_order }}</td>
                            <td>
                                @if ($collection->is_published)
                                    <span class="text-[var(--ok)]">Published</span>
                                @else
                                    <span class="text-[var(--mist)]">Draft</span>
                                @endif
                                @if ($collection->is_featured)
                                    <span class="text-[var(--accent)] ml-1">· Featured</span>
                                @endif
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <a href="{{ route('admin.collections.edit', $collection) }}" class="text-xs text-[var(--accent)] hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.collections.destroy', $collection) }}" method="POST" class="inline" onsubmit="return confirm('Delete this collection?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-[var(--danger)] hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-[var(--mist)] py-8">No collections yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $collections->links() }}</div>
</div>
@endsection
