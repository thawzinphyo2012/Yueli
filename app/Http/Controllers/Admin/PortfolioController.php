<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $projects = PortfolioProject::orderBy('sort_order')->paginate(15);

        return view('admin.portfolio.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.portfolio.form', ['project' => new PortfolioProject]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['gallery'] = $this->parseGallery($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        } elseif ($request->filled('image_url')) {
            $data['cover_image'] = $request->input('image_url');
        }

        PortfolioProject::create($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Project created.');
    }

    public function edit(PortfolioProject $project): View
    {
        return view('admin.portfolio.form', compact('project'));
    }

    public function update(Request $request, PortfolioProject $project): RedirectResponse
    {
        $data = $this->validated($request);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['gallery'] = $this->parseGallery($request);

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image && ! str_starts_with($project->cover_image, 'http')) {
                Storage::disk('public')->delete($project->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('portfolio', 'public');
        } elseif ($request->filled('image_url')) {
            $data['cover_image'] = $request->input('image_url');
        }

        $project->update($data);

        return redirect()->route('admin.portfolio.index')->with('success', 'Project updated.');
    }

    public function destroy(PortfolioProject $project): RedirectResponse
    {
        $project->delete();

        return back()->with('success', 'Project deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'client' => ['nullable', 'string', 'max:120'],
            'role' => ['nullable', 'string', 'max:120'],
            'year' => ['nullable', 'string', 'max:20'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:4096'],
            'image_url' => ['nullable', 'url'],
            'gallery_urls' => ['nullable', 'string'],
        ]);
    }

    protected function parseGallery(Request $request): array
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

        while (PortfolioProject::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
