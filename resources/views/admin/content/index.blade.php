@extends('layouts.admin')

@section('title', 'Content')
@section('heading', 'Content')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">Content</h1>
            <p class="text-sm text-[var(--mist)] mt-1">Page blocks & CTAs</p>
        </div>
        <a href="{{ route('admin.content.create') }}" class="admin-btn">
            <i data-lucide="plus" class="w-4 h-4"></i> Add block
        </a>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Title</th>
                        <th>Page</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($blocks as $block)
                        <tr>
                            <td class="font-semibold font-mono text-xs">{{ $block->key }}</td>
                            <td>{{ $block->title ?: '—' }}</td>
                            <td>{{ $block->page }}</td>
                            <td>{{ $block->sort_order }}</td>
                            <td>
                                @if ($block->is_active)
                                    <span class="text-[var(--ok)]">Active</span>
                                @else
                                    <span class="text-[var(--mist)]">Inactive</span>
                                @endif
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <a href="{{ route('admin.content.edit', $block) }}" class="text-xs text-[var(--accent)] hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.content.destroy', $block) }}" method="POST" class="inline" onsubmit="return confirm('Delete this content block?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-[var(--danger)] hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-[var(--mist)] py-8">No content blocks yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $blocks->links() }}</div>
</div>
@endsection
