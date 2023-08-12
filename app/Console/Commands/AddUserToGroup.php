<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\User;
use Illuminate\Console\Command;

class AddUserToGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:member';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user to group and activate if inactive';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user_id = $this->ask('Enter user_id:');
        $group_id = $this->ask('Enter group_id:');

        $user = User::query()->findOrFail($user_id);

        $group = Group::query()->findOrFail($group_id);

        /** @var User $user */
        if (!$user->active) {
            $user->active = true;
            $user->save();
        }

        /** @var Group $group */
        $user->groups()->save($group);

        $this->info('User added to group successfully.');
    }
}
