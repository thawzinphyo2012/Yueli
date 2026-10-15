<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        $collections = Collection::orderBy('sort_order')->paginate(15);

        return view('admin.collections.index', compact('collections'));
    }

    public function create(): View
    {
        return view('admin.collections.form', ['collection' => new Collection]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('collections', 'public');
        } elseif ($request->filled('image_url')) {
            $data['cover_image'] = $request->input('image_url');
        }

        Collection::create($data);

        return redirect()->route('admin.collections.index')->with('success', 'Collection created.');
    }

    public function edit(Collection $collection): View
    {
        return view('admin.collections.form', compact('collection'));
    }

    public function update(Request $request, Collection $collection): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            if ($collection->cover_image && ! str_starts_with($collection->cover_image, 'http')) {
                Storage::disk('public')->delete($collection->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('collections', 'public');
        } elseif ($request->filled('image_url')) {
            $data['cover_image'] = $request->input('image_url');
        }

        $collection->update($data);

        return redirect()->route('admin.collections.index')->with('success', 'Collection updated.');
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        $collection->delete();

        return back()->with('success', 'Collection deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'season' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url'],
        ]);
    }

    protected function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Collection::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
