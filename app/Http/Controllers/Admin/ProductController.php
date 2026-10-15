<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('collection')->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product,
            'collections' => Collection::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['sizes'] = $this->csvToArray($request->input('sizes'));
        $data['colors'] = $this->csvToArray($request->input('colors'));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('primary_image')) {
            $data['primary_image'] = $request->file('primary_image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'collections' => Collection::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product->id);
        $data['slug'] = $product->slug ?: $this->uniqueSlug($data['name']);
        $data['sizes'] = $this->csvToArray($request->input('sizes'));
        $data['colors'] = $this->csvToArray($request->input('colors'));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('primary_image')) {
            if ($product->primary_image && ! str_starts_with($product->primary_image, 'http')) {
                Storage::disk('public')->delete($product->primary_image);
            }
            $data['primary_image'] = $request->file('primary_image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->primary_image && ! str_starts_with($product->primary_image, 'http')) {
            Storage::disk('public')->delete($product->primary_image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'collection_id' => ['nullable', 'exists:collections,id'],
            'name' => ['required', 'string', 'max:160'],
            'sku' => ['nullable', 'string', 'max:60', 'unique:products,sku,'.($ignoreId ?? 'NULL')],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_at_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'primary_image' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url'],
        ]) + (
            $request->filled('image_url') && ! $request->hasFile('primary_image')
                ? ['primary_image' => $request->input('image_url')]
                : []
        );
    }

    protected function csvToArray(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return collect(explode(',', $value))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->values()
            ->all();
    }

    protected function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
