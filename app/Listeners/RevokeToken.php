<?php

namespace App\Listeners;

use App\Events\UserLogIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RevokeToken
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLogIn $event): void
    {
        $event->user->tokens()->delete();
    }
}
