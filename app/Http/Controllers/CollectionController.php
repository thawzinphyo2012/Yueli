<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        $collections = Collection::query()
            ->withCount(['products' => fn ($q) => $q->where('is_published', true)])
            ->with(['products' => fn ($q) => $q->where('is_published', true)->latest()->take(3)])
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return view('storefront.collections.index', compact('collections'));
    }

    public function show(Collection $collection): View
    {
        abort_unless($collection->is_published, 404);

        $collection->load([
            'products' => fn ($q) => $q->where('is_published', true),
            'lookbooks' => fn ($q) => $q->where('is_published', true)->orderBy('sort_order'),
        ]);

        $moodImages = $collection->lookbooks
            ->flatMap(fn ($lookbook) => collect([$lookbook->cover_image])->merge($lookbook->images ?? []))
            ->filter()
            ->unique()
            ->take(6)
            ->values();

        return view('storefront.collections.show', compact('collection', 'moodImages'));
    }
}
