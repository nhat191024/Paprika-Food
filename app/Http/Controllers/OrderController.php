<?php

namespace App\Http\Controllers;

use App\Actions\Cart\CartManager;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class OrderController extends Controller
{
    public function index(CartManager $cart): View
    {
        $orders = Order::query()
            ->with(['items.product.thumbnail', 'items.variant', 'items.selections.product', 'items.selections.variant'])
            ->when(
                auth()->check(),
                fn (Builder $query) => $query->where('user_id', auth()->id()),
                fn (Builder $query) => $query->whereIn('id', $cart->rememberedOrderIds() ?: [0]),
            )
            ->latest()
            ->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }
}
