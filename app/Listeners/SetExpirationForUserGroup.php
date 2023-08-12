<?php

namespace App\Listeners;

use App\Events\UserAddedToGroup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetExpirationForUserGroup implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserAddedToGroup $event): void
    {
        $user = $event->user;
        $group = $event->group;

        $expireHours = $group->expire_hours;

        $user->groups()->updateExistingPivot($group->id, [
            'expired_at' => now()->addHours($expireHours)->toDateTimeString()
        ]);
    }
}
