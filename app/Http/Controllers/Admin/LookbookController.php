<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Lookbook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LookbookController extends Controller
{
    public function index(): View
    {
        $lookbooks = Lookbook::with('collection')->orderBy('sort_order')->paginate(15);

        return view('admin.lookbooks.index', compact('lookbooks'));
    }

    public function create(): View
    {
        return view('admin.lookbooks.form', [
            'lookbook' => new Lookbook,
            'collections' => Collection::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_campaign'] = $request->boolean('is_campaign');
        $data['is_published'] = $request->boolean('is_published');
        $data['images'] = $this->parseImages($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('lookbooks', 'public');
        } elseif ($request->filled('image_url')) {
            $data['cover_image'] = $request->input('image_url');
        }

        Lookbook::create($data);

        return redirect()->route('admin.lookbooks.index')->with('success', 'Lookbook created.');
    }

    public function edit(Lookbook $lookbook): View
    {
        return view('admin.lookbooks.form', [
            'lookbook' => $lookbook,
            'collections' => Collection::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Lookbook $lookbook): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_campaign'] = $request->boolean('is_campaign');
        $data['is_published'] = $request->boolean('is_published');
        $data['images'] = $this->parseImages($request);

        if ($request->hasFile('cover_image')) {
            if ($lookbook->cover_image && ! str_starts_with($lookbook->cover_image, 'http')) {
                Storage::disk('public')->delete($lookbook->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('lookbooks', 'public');
        } elseif ($request->filled('image_url')) {
            $data['cover_image'] = $request->input('image_url');
        }

        $lookbook->update($data);

        return redirect()->route('admin.lookbooks.index')->with('success', 'Lookbook updated.');
    }

    public function destroy(Lookbook $lookbook): RedirectResponse
    {
        $lookbook->delete();

        return back()->with('success', 'Lookbook deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'collection_id' => ['nullable', 'exists:collections,id'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string'],
            'photographer' => ['nullable', 'string', 'max:120'],
            'location' => ['nullable', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url'],
            'gallery_urls' => ['nullable', 'string'],
        ]);
    }

    protected function parseImages(Request $request): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $request->input('gallery_urls')))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->values()
            ->all();
    }

    protected function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Lookbook::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
