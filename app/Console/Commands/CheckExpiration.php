<?php

namespace App\Console\Commands;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:check_expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and remove users from groups if expired';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $now = Carbon::now();
        $group = Group::query()->where(Group::ATTR_ID, 1)->first();

        foreach ($group->users as $user) {
            if ($user->pivot_expired_at < $now) {
                Mail::raw("Здравствуйте {$user->name}! Истекло время вашего участия в группе {$group->name}.", function ($message) use ($user) {
                    $message->to($user->email)->subject('Истекло время участия в группе');
                });

                /** @var Group $group */
                $user->groups()->detach($group->id);

                if ($user->groups()->count() === 0) {
                    $user->update(['active' => false]);
                }
            }
        }

        $this->info('Expired users removed from groups.');
    }
}
