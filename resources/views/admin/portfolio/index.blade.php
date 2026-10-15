@extends('layouts.admin')

@section('title', 'Portfolio')
@section('heading', 'Portfolio')

@section('content')
<div class="space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold tracking-tight">Portfolio</h1>
            <p class="text-sm text-[var(--mist)] mt-1">Studio projects</p>
        </div>
        <a href="{{ route('admin.portfolio.create') }}" class="admin-btn">
            <i data-lucide="plus" class="w-4 h-4"></i> Add project
        </a>
    </div>

    <div class="bg-[var(--graphite)] border border-[var(--edge)] rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Year</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td class="font-semibold">{{ $project->title }}</td>
                            <td>{{ $project->client ?: '—' }}</td>
                            <td>{{ $project->year ?: '—' }}</td>
                            <td>{{ $project->sort_order }}</td>
                            <td>
                                @if ($project->is_published)
                                    <span class="text-[var(--ok)]">Published</span>
                                @else
                                    <span class="text-[var(--mist)]">Draft</span>
                                @endif
                                @if ($project->is_featured)
                                    <span class="text-[var(--accent)] ml-1">· Featured</span>
                                @endif
                            </td>
                            <td class="text-right whitespace-nowrap">
                                <a href="{{ route('admin.portfolio.edit', $project) }}" class="text-xs text-[var(--accent)] hover:underline mr-3">Edit</a>
                                <form action="{{ route('admin.portfolio.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-[var(--danger)] hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-[var(--mist)] py-8">No projects yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $projects->links() }}</div>
</div>
@endsection
