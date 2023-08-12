<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property int $expire_hours
 */
class Group extends Model
{
    use HasFactory;

    const ATTR_ID = 'id',
        ATTR_NAME = 'name',
        ATTR_EXPIRE_HOUR = 'expire_hours';

    protected $fillable = [
        self::ATTR_ID,
        self::ATTR_NAME,
        self::ATTR_EXPIRE_HOUR,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('expired_at')
            ->withTimestamps();
    }
}
