<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners = \App\Models\Banner::with('image')
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        $featuredProducts = \App\Models\Product::with('thumbnail')
            ->withCount(['variants', 'comboGroups'])
            ->whereState('status', \App\States\Product\Active::class)
            ->take(3)
            ->get();

        return view('home.home', compact('banners', 'featuredProducts'));
    }
}
