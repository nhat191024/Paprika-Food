<?php

namespace App\Http\Controllers;

use App\Actions\Cart\CartManager;
use App\Enums\OrderType;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\States\Order\Pending;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(CartManager $cart): View|RedirectResponse
    {
        $summary = $cart->summary();

        if ($summary['is_empty']) {
            return redirect()->route('menu');
        }

        return view('checkout.show', [
            'cart' => $summary,
        ]);
    }

    public function store(CheckoutRequest $request, CartManager $cart): RedirectResponse
    {
        $summary = $cart->summary();

        if ($summary['is_empty']) {
            return redirect()->route('menu');
        }

        $order = DB::transaction(function () use ($request, $cart, $summary): Order {
            $order = Order::query()->create([
                'user_id' => $request->user()?->id,
                'order_number' => $this->generateOrderNumber(),
                'total_amount' => $summary['subtotal'],
                'discount_amount' => 0,
                'final_amount' => $summary['total'],
                'status' => Pending::class,
                'payment_method' => (string) $request->string('payment_method'),
                'order_type' => OrderType::ONLINE,
                'delivery_recipient_name' => (string) $request->string('delivery_recipient_name'),
                'delivery_phone' => (string) $request->string('delivery_phone'),
                'delivery_address_detail' => trim((string) $request->string('delivery_address_detail')."\n".(string) $request->string('delivery_note')),
                'scheduled_delivery_time' => $request->date('scheduled_delivery_time'),
            ]);

            foreach ($summary['items'] as $cartItem) {
                $orderItem = $order->items()->create([
                    'product_id' => $cartItem['product_id'],
                    'product_variant_id' => $cartItem['product_variant_id'],
                    'product_name' => $cartItem['name'],
                    'product_variant_name' => $cartItem['variant_name'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['unit_price'],
                ]);

                foreach ($cartItem['combo_selections'] as $selection) {
                    $orderItem->selections()->create([
                        'combo_group_id' => $selection['combo_group_id'],
                        'combo_group_item_id' => $selection['combo_group_item_id'],
                        'product_id' => $selection['product_id'],
                        'product_variant_id' => $selection['product_variant_id'],
                        'combo_group_name' => $selection['combo_group_name'],
                        'selection_name' => $selection['label'],
                        'extra_price' => $selection['extra_price'],
                    ]);
                }
            }

            $cart->rememberOrder($order->id);
            $cart->clear();

            return $order;
        });

        return redirect()
            ->route('orders.index')
            ->with('status', __('client/checkout.order_created', ['order' => $order->order_number]));
    }

    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Order::query()->where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
