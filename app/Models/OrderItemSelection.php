<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_item_id
 * @property int $product_id
 * @property numeric $extra_price
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\OrderItem $orderItem
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereExtraPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['order_item_id', 'product_id', 'extra_price'])]
class OrderItemSelection extends Model
{
    protected function casts(): array
    {
        return [
            'extra_price' => 'decimal:2',
        ];
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
