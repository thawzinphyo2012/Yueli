<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\ContentBlock;
use App\Models\Lookbook;
use App\Models\PortfolioProject;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $hero = ContentBlock::query()->where('key', 'home_hero')->where('is_active', true)->first();
        $about = ContentBlock::query()->where('key', 'home_about')->where('is_active', true)->first();
        $studioIntro = ContentBlock::query()->where('key', 'portfolio_intro')->where('is_active', true)->first();

        $collections = Collection::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        $products = Product::query()
            ->with('collection')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        $campaign = Lookbook::query()
            ->where('is_published', true)
            ->where('is_campaign', true)
            ->orderBy('sort_order')
            ->first();

        $projects = PortfolioProject::query()
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('storefront.home', compact(
            'hero',
            'about',
            'studioIntro',
            'collections',
            'products',
            'campaign',
            'projects'
        ));
    }
}
