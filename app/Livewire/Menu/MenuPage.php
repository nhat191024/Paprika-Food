<?php

namespace App\Livewire\Menu;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.main', ['title' => 'Menu'])]
class MenuPage extends Component
{
    public function render()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->with('thumbnail')->withCount(['variants', 'comboGroups']);
        }])
            ->whereHas('products')
            ->orderBy('order')
            ->get();

        return view('livewire.menu.menu-page', [
            'categories' => $categories,
        ]);
    }
}
