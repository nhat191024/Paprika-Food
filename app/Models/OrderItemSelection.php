<?php

namespace App\Models;

use Carbon\CarbonImmutable;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $order_item_id
 * @property int|null $combo_group_id
 * @property int|null $combo_group_item_id
 * @property int $product_id
 * @property int|null $product_variant_id
 * @property string|null $combo_group_name
 * @property string|null $selection_name
 * @property numeric $extra_price
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \App\Models\ComboGroup|null $comboGroup
 * @property-read \App\Models\ComboGroupItem|null $comboGroupItem
 * @property-read \App\Models\OrderItem $orderItem
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\ProductVariant|null $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereComboGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereComboGroupItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereComboGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereExtraPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereOrderItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereProductVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereSelectionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrderItemSelection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['order_item_id', 'combo_group_id', 'combo_group_item_id', 'product_id', 'product_variant_id', 'combo_group_name', 'selection_name', 'extra_price'])]
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

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function comboGroup(): BelongsTo
    {
        return $this->belongsTo(ComboGroup::class);
    }

    public function comboGroupItem(): BelongsTo
    {
        return $this->belongsTo(ComboGroupItem::class);
    }
}
