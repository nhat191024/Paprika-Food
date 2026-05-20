<?php

namespace App\Models;

use App\Enums\OrderType;
use App\Enums\PaymentMethods;
use App\States\Order\OrderState;

use Carbon\CarbonImmutable;
use Database\Factories\OrderFactory;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\ModelStates\HasStates;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $order_number
 * @property numeric $total_amount
 * @property numeric $discount_amount
 * @property numeric $final_amount
 * @property int|null $voucher_id
 * @property string|null $voucher_code
 * @property OrderState $status
 * @property PaymentMethods $payment_method
 * @property OrderType $order_type
 * @property int|null $customer_address_id
 * @property string|null $delivery_recipient_name
 * @property string|null $delivery_phone
 * @property string|null $delivery_address_detail
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\CustomerAddress|null $customerAddress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Voucher|null $voucher
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order orWhereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order orWhereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCustomerAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryAddressDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDeliveryRecipientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereFinalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereNotState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereOrderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereState(string $column, $states)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereVoucherCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereVoucherId($value)
 * @mixin \Eloquent
 */
#[Fillable(['user_id', 'order_number', 'total_amount', 'discount_amount', 'final_amount', 'voucher_id', 'voucher_code', 'status', 'payment_method', 'order_type', 'customer_address_id', 'delivery_recipient_name', 'delivery_phone', 'delivery_address_detail', 'scheduled_delivery_time'])]
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory, HasStates;

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'final_amount' => 'decimal:2',
            'order_type' => OrderType::class,
            'status' => OrderState::class,
            'payment_method' => PaymentMethods::class,
            'scheduled_delivery_time' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function customerAddress(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
