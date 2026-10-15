<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->where('is_published', true)->with('collection');

        if ($request->filled('collection')) {
            $query->whereHas('collection', fn ($q) => $q->where('slug', $request->collection));
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            });
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $collections = Collection::query()->where('is_published', true)->orderBy('sort_order')->get();

        return view('storefront.shop.index', compact('products', 'collections'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_published, 404);

        $related = Product::query()
            ->where('is_published', true)
            ->where('id', '!=', $product->id)
            ->when($product->collection_id, fn ($q) => $q->where('collection_id', $product->collection_id))
            ->take(4)
            ->get();

        return view('storefront.shop.show', compact('product', 'related'));
    }
}
