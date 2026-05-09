<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $combo_group_id
 * @property int|null $product_id
 * @property int|null $product_variant_id
 * @property numeric $extra_price
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \App\Models\ComboGroup $comboGroup
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\ProductVariant|null $variant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem whereComboGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem whereExtraPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem whereProductVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroupItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['combo_group_id', 'product_id', 'product_variant_id', 'extra_price'])]
class ComboGroupItem extends Model
{
    protected function casts(): array
    {
        return [
            'extra_price' => 'decimal:2',
        ];
    }

    public function comboGroup(): BelongsTo
    {
        return $this->belongsTo(ComboGroup::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
