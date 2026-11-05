<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        ContentBlock::ensurePageDefaults();

        $catalog = ContentBlock::pageCatalog();
        $counts = ContentBlock::query()
            ->selectRaw('page, count(*) as total')
            ->groupBy('page')
            ->pluck('total', 'page');

        $pages = collect($catalog)->map(function (array $meta, string $key) use ($counts) {
            return [
                'key' => $key,
                'label' => $meta['label'],
                'description' => $meta['description'],
                'sections' => count($meta['sections']),
                'saved' => (int) ($counts[$key] ?? 0),
            ];
        })->values();

        return view('admin.content.index', compact('pages'));
    }

    public function page(string $page): View
    {
        ContentBlock::ensurePageDefaults();

        $catalog = ContentBlock::pageCatalog();
        abort_unless(isset($catalog[$page]), 404);

        $meta = $catalog[$page];
        $blocks = ContentBlock::query()
            ->where('page', $page)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('key');

        $sections = collect($meta['sections'])->map(function (array $section, string $key) use ($blocks) {
            return [
                'key' => $key,
                'label' => $section['label'],
                'block' => $blocks->get($key),
            ];
        })->values();

        return view('admin.content.page', [
            'pageKey' => $page,
            'pageMeta' => $meta,
            'sections' => $sections,
        ]);
    }

    public function create(Request $request): View
    {
        $block = new ContentBlock([
            'page' => $request->query('page', 'home'),
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return view('admin.content.form', [
            'block' => $block,
            'pages' => ContentBlock::pageCatalog(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = collect($this->validated($request))
            ->except(['image', 'image_url', 'remove_image'])
            ->all();
        $data['is_active'] = $request->boolean('is_active');
        $data['image'] = $this->resolveImage($request);

        $block = ContentBlock::create($data);

        return redirect()
            ->route('admin.content.page', $block->page)
            ->with('success', 'Section created.');
    }

    public function edit(ContentBlock $content): View
    {
        return view('admin.content.form', [
            'block' => $content,
            'pages' => ContentBlock::pageCatalog(),
        ]);
    }

    public function update(Request $request, ContentBlock $content): RedirectResponse
    {
        $data = collect($this->validated($request, $content))
            ->except(['image', 'image_url', 'remove_image'])
            ->all();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->boolean('remove_image')) {
            $this->deleteStoredImage($content->image);
            $data['image'] = null;
        } else {
            $image = $this->resolveImage($request, $content);
            if ($image !== null) {
                $data['image'] = $image;
            }
        }

        $content->update($data);

        return redirect()
            ->route('admin.content.page', $content->page)
            ->with('success', 'Section updated — text and image saved.');
    }

    public function destroy(ContentBlock $content): RedirectResponse
    {
        $page = $content->page;
        $this->deleteStoredImage($content->image);
        $content->delete();

        return redirect()
            ->route('admin.content.page', $page)
            ->with('success', 'Section deleted.');
    }

    protected function validated(Request $request, ?ContentBlock $existing = null): array
    {
        $pageKeys = array_keys(ContentBlock::pageCatalog());

        return $request->validate([
            'key' => [
                'required',
                'string',
                'max:80',
                Rule::unique('content_blocks', 'key')->ignore($existing?->id),
            ],
            'title' => ['nullable', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'eyebrow' => ['nullable', 'string', 'max:120'],
            'body' => ['nullable', 'string'],
            'cta_label' => ['nullable', 'string', 'max:80'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'cta2_label' => ['nullable', 'string', 'max:80'],
            'cta2_url' => ['nullable', 'string', 'max:255'],
            'page' => ['required', 'string', 'max:40', Rule::in($pageKeys)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:5120'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }

    protected function resolveImage(Request $request, ?ContentBlock $existing = null): ?string
    {
        if ($request->hasFile('image')) {
            if ($existing) {
                $this->deleteStoredImage($existing->image);
            }

            return $request->file('image')->store('content', 'public');
        }

        if ($request->filled('image_url')) {
            if ($existing) {
                $this->deleteStoredImage($existing->image);
            }

            return $request->input('image_url');
        }

        return null;
    }

    protected function deleteStoredImage(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'http')) {
            Storage::disk('public')->delete($path);
        }
    }
}
