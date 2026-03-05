<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipPlan extends Model
{
    use HasFactory;
    protected $table = 'memberships_plans';

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
