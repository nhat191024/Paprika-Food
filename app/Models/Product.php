<?php

namespace App\Models;

use App\States\Product\ProductState;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

use Slimani\MediaManager\Concerns\InteractsWithMediaFiles;
use Slimani\MediaManager\Models\File;
use Slimani\MediaManager\Models\MediaAttachment;

use Spatie\ModelStates\HasStates;

use Spatie\Translatable\Attributes\Translatable;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $category_id
 * @property string $slug
 * @property array<array-key, mixed> $name
 * @property array<array-key, mixed>|null $description
 * @property numeric $price
 * @property bool $is_combo
 * @property ProductState $status
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read Collection<int, \App\Models\ComboGroup> $comboGroups
 * @property-read int|null $combo_groups_count
 * @property-read array $translatable_columns_from
 * @property-read Collection<int, MediaAttachment> $mediaAttachments
 * @property-read int|null $media_attachments_count
 * @property-read Collection<int, File> $thumbnail
 * @property-read int|null $thumbnail_count
 * @property-read mixed $translations
 * @property-read Collection<int, \App\Models\ProductVariant> $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereIsCombo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLocale(string $column, string $locale)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereLocales(string $column, array $locales)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['category_id', 'slug', 'name', 'description', 'price', 'is_combo', 'status'])]
#[Translatable('name', 'description')]
class Product extends Model
{
    use HasStates, HasTranslations, InteractsWithMediaFiles;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_combo' => 'boolean',
            'status' => ProductState::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comboGroups(): HasMany
    {
        return $this->hasMany(ComboGroup::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function thumbnail(): MorphToMany
    {
        return $this->mediaFiles('thumbnail');
    }
}
