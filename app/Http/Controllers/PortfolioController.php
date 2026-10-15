<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use App\Models\PortfolioProject;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $intro = ContentBlock::query()->where('key', 'portfolio_intro')->where('is_active', true)->first();
        $projects = PortfolioProject::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return view('storefront.portfolio.index', compact('projects', 'intro'));
    }

    public function show(PortfolioProject $project): View
    {
        abort_unless($project->is_published, 404);

        return view('storefront.portfolio.show', compact('project'));
    }
}
