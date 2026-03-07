<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use App\Models\User;

/**
 * @property int $id
 * @property string $email
 * @property string $code
 * @property Carbon $expires_at
 * @property Carbon|null $used_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SecurityCode whereUsedAt($value)
 * @mixin \Eloquent
 */
class SecurityCode extends Model
{


    protected $table = 'security_codes';

    protected $fillable = [
        'email',
        'code',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'email','email');
    }
}
