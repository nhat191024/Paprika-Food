<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class ShopController extends Controller
{
    public function details(string $product_slug): View
    {
        $product = Product::query()
            ->with([
                'category',
                'comboGroups.items.product',
                'comboGroups.items.variant.product',
                'thumbnail',
                'variants' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
            ])
            ->where('slug', $product_slug)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->with('thumbnail')
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->getKey())
            ->latest()
            ->limit(4)
            ->get();

        return view('details.details', compact('product', 'relatedProducts'));
    }
}
