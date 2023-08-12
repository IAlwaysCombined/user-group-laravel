<?php

namespace App\Events;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAddedToGroup
{
    use Dispatchable, SerializesModels;

    public User $user;
    public Group $group;

    public function __construct(User $user, Group $group)
    {
        $this->user = $user;
        $this->group = $group;
    }
}
