<?php

namespace App\Http\Controllers;

use App\Models\ContentBlock;
use App\Models\Setting;
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
        $intro = ContentBlock::query()
            ->where('key', 'contact_intro')
            ->where('is_active', true)
            ->first();

        $contact = [
            'email' => Setting::get('contact_email', 'studio@yuelistudio.com'),
            'phone' => Setting::get('contact_phone', ''),
            'address' => Setting::get('address', ''),
        ];

        return view('storefront.contact', compact('intro', 'contact'));
    }
}
