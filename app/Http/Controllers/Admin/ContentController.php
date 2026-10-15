<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        $blocks = ContentBlock::orderBy('page')->orderBy('sort_order')->paginate(20);

        return view('admin.content.index', compact('blocks'));
    }

    public function create(): View
    {
        return view('admin.content.form', ['block' => new ContentBlock]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('content', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        ContentBlock::create($data);

        return redirect()->route('admin.content.index')->with('success', 'Content block created.');
    }

    public function edit(ContentBlock $content): View
    {
        return view('admin.content.form', ['block' => $content]);
    }

    public function update(Request $request, ContentBlock $content): RedirectResponse
    {
        $data = $this->validated($request, $content->id);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($content->image && ! str_starts_with($content->image, 'http')) {
                Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $request->file('image')->store('content', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        $content->update($data);

        return redirect()->route('admin.content.index')->with('success', 'Content block updated.');
    }

    public function destroy(ContentBlock $content): RedirectResponse
    {
        $content->delete();

        return back()->with('success', 'Content block deleted.');
    }

    protected function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'key' => ['required', 'string', 'max:80', 'unique:content_blocks,key,'.($ignoreId ?? 'NULL')],
            'title' => ['nullable', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'cta_label' => ['nullable', 'string', 'max:80'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'page' => ['required', 'string', 'max:40'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url'],
        ]);
    }
}
