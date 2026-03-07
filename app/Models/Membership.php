<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $membership_plan_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $status
 * @property string $payment_method
 * @property string|null $cancellation_reason
 * @property \Illuminate\Support\Carbon|null $cancelled_at
 * @property numeric $price_paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MembershipPlan $membershipPlan
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\MembershipFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereCancellationReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereMembershipPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership wherePricePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Membership whereUserId($value)
 * @mixin \Eloquent
 */
class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'status',
        'payment_method',
        'cancellation_reason',
        'cancelled_at',
        'price_paid',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'cancelled_at' => 'datetime',
        'price_paid' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function membershipPlan(): BelongsTo
    {
        return $this->belongsTo(MembershipPlan::class,'membership_plan_id');
    }
}
