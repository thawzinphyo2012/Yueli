<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $blocks = ContentBlock::query()
            ->where('page', 'about')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('storefront.about', compact('blocks'));
    }

    public function contact(): View
    {
        return view('storefront.contact');
    }
}
