<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property numeric $price
 * @property int $duration_value
 * @property string $duration_unit
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Membership> $memberships
 * @property-read int|null $memberships_count
 * @method static \Database\Factories\MembershipPlanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereDurationUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereDurationValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MembershipPlan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MembershipPlan extends Model
{
    use HasFactory;
    protected $table = 'membership_plans';

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_value',
        'duration_unit',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price'=>'decimal:2',
            'duration_value'=>'integer',
        ];
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class,'membership_plan_id');
    }
}
