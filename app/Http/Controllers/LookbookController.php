<?php

namespace App\Http\Controllers;

use App\Models\Lookbook;
use Illuminate\View\View;

class LookbookController extends Controller
{
    public function index(): View
    {
        $lookbooks = Lookbook::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $campaigns = $lookbooks->where('is_campaign', true);
        $editorials = $lookbooks->where('is_campaign', false);

        return view('storefront.lookbook.index', compact('campaigns', 'editorials'));
    }

    public function show(Lookbook $lookbook): View
    {
        abort_unless($lookbook->is_published, 404);

        $lookbook->load('collection');

        return view('storefront.lookbook.show', compact('lookbook'));
    }
}
