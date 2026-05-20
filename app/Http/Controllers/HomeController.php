<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners = Banner::with('image')
            ->where('status', true)
            ->orderBy('sort_order')
            ->get();

        return view('home.home', compact('banners'));
    }
}
