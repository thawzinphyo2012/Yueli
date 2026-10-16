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
        $published = Product::query()->where('is_published', true);
        $priceFloor = (int) floor((float) ((clone $published)->min('price') ?? 0));
        $priceCeil = (int) ceil((float) ((clone $published)->max('price') ?? 0));
        if ($priceCeil < $priceFloor) {
            $priceCeil = $priceFloor;
        }

        $query = Product::query()->where('is_published', true)->with('collection');

        if ($request->filled('collection')) {
            $query->whereHas('collection', fn ($q) => $q->where('slug', $request->collection));
        }

        if ($request->get('type') === 'featured') {
            $query->where('is_featured', true);
        } elseif ($request->get('type') === 'sale') {
            $query->whereNotNull('compare_at_price')->whereColumn('compare_at_price', '>', 'price');
        }

        $min = $request->filled('min') ? (int) $request->min : $priceFloor;
        $max = $request->filled('max') ? (int) $request->max : $priceCeil;
        $min = max($priceFloor, min($min, $priceCeil));
        $max = max($priceFloor, min($max, $priceCeil));
        if ($min > $max) {
            [$min, $max] = [$max, $min];
        }
        if ($min > $priceFloor) {
            $query->where('price', '>=', $min);
        }
        if ($max < $priceCeil) {
            $query->where('price', '<=', $max);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('short_description', 'like', "%{$q}%");
            });
        }

        $products = $query->latest()->paginate(8)->withQueryString();
        $collections = Collection::query()->where('is_published', true)->orderBy('sort_order')->get();

        return view('storefront.shop.index', compact('products', 'collections', 'priceFloor', 'priceCeil', 'min', 'max'));
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
