@extends('layouts.admin')

@section('title', 'Lookbooks')
@section('heading', 'Lookbooks')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">Lookbooks</h1>
            <p class="text-sm text-[var(--mist)] mt-1">Editorial galleries</p>
        </div>
        <a href="{{ route('admin.lookbooks.create') }}" class="admin-btn">
            <i data-lucide="plus" class="w-4 h-4"></i> Add lookbook
        </a>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Collection</th>
                        <th>Photographer</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lookbooks as $lookbook)
                        <tr>
                            <td class="font-semibold">{{ $lookbook->title }}</td>
                            <td>{{ $lookbook->collection?->name ?? '—' }}</td>
                            <td>{{ $lookbook->photographer ?: '—' }}</td>
                            <td>{{ $lookbook->sort_order }}</td>
                            <td>
                                @if ($lookbook->is_published)
                                    <span class="text-[var(--ok)]">Published</span>
                                @else
                                    <span class="text-[var(--mist)]">Draft</span>
                                @endif
                                @if ($lookbook->is_campaign)
                                    <span class="text-[var(--accent)] ml-1">· Campaign</span>
                                @endif
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <a href="{{ route('admin.lookbooks.edit', $lookbook) }}" class="text-xs text-[var(--accent)] hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.lookbooks.destroy', $lookbook) }}" method="POST" class="inline" onsubmit="return confirm('Delete this lookbook?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-[var(--danger)] hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-[var(--mist)] py-8">No lookbooks yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $lookbooks->links() }}</div>
</div>
@endsection
