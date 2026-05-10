<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

use Slimani\MediaManager\Concerns\InteractsWithMediaFiles;
use Slimani\MediaManager\Models\File;
use Slimani\MediaManager\Models\MediaAttachment;

/**
 * @property int $id
 * @property string|null $title
 * @property string|null $link
 * @property int $sort_order
 * @property bool $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, MediaAttachment> $mediaAttachments
 * @property-read int|null $media_attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, File> $thumbnail
 * @property-read int|null $thumbnail_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
#[Fillable(['title', 'link', 'sort_order', 'status'])]
class Banner extends Model
{
    use InteractsWithMediaFiles;

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function thumbnail(): MorphToMany
    {
        return $this->mediaFiles('thumbnail');
    }
}
