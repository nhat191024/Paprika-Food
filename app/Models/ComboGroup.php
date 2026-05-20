<?php

namespace App\Models;

use Carbon\CarbonImmutable;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $product_id
 * @property array<array-key, mixed> $name
 * @property int $min_select
 * @property int $max_select
 * @property bool $is_required
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read array $translatable_columns_from
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ComboGroupItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Product $product
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereMaxSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereMinSelect($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ComboGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['product_id', 'name', 'min_select', 'max_select', 'is_required'])]
#[Translatable('name')]
class ComboGroup extends Model
{
    use HasTranslations;

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ComboGroupItem::class);
    }
}
