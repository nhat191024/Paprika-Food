<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $location_id
 * @property string $recipient_name
 * @property string $phone
 * @property string $address_detail
 * @property bool $is_default
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Location|null $location
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereAddressDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereRecipientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerAddress whereUserId($value)
 * @mixin \Eloquent
 */
#[Fillable(['user_id', 'location_id', 'recipient_name', 'phone', 'address_detail', 'is_default'])]
class CustomerAddress extends Model
{
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
