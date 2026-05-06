<?php

namespace App\Models;

use App\Enums\ProductStatus;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
 * @property ProductStatus $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ComboGroup> $comboGroups
 * @property-read int|null $combo_groups_count
 * @property-read array $translatable_columns_from
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read mixed $translations
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product newQuery()
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['category_id', 'slug', 'name', 'description', 'price', 'is_combo', 'status'])]
#[Translatable('name', 'description')]
class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_combo' => 'boolean',
            'status' => ProductStatus::class,
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

    /*
    * Register the media collections for the model.
    */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('thumbnail')
            ->useDisk('public');
    }

    /**
     * Summary of registerMediaConversions
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnail_webp')
            ->width(400)
            ->height(400)
            ->format('webp')
            ->performOnCollections('thumbnail')
            ->optimize()
            ->queued();
    }
}
