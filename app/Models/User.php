<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property boolean $active
 * @property string $email
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    CONST ATTR_ID = 'id',
        ATTR_NAME = 'name',
        ATTR_ACTIVE = 'active',
        ATTR_EMAIL = 'email';

    CONST RELATION_GROUPS = 'groups';

    protected $fillable = [
        self::ATTR_ID,
        self::ATTR_NAME,
        self::ATTR_ACTIVE,
        self::ATTR_EMAIL,
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)
            ->withPivot('expired_at')
            ->withTimestamps();
    }
}
