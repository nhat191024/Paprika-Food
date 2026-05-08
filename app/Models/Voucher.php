<?php

namespace App\Models;

use App\States\Voucher\VoucherState;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

use Spatie\ModelStates\HasStates;

/**
 * @property int $id
 * @property string $code
 * @property string $discount_type
 * @property numeric $discount_value
 * @property numeric $min_order_amount
 * @property numeric|null $max_discount
 * @property \Carbon\CarbonImmutable $start_date
 * @property \Carbon\CarbonImmutable $end_date
 * @property int|null $usage_limit
 * @property int $used_count
 * @property VoucherState $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereMaxDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereMinOrderAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereUsageLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Voucher whereUsedCount($value)
 * @mixin \Eloquent
 */
#[Fillable(['code', 'discount_type', 'discount_value', 'min_order_amount', 'max_discount', 'start_date', 'end_date', 'usage_limit', 'used_count', 'status'])]
class Voucher extends Model
{
    use HasStates;

    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => VoucherState::class,
        ];
    }
}
