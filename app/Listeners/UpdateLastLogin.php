<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;


class UpdateLastLogin
{

    // protected $userActivityService;
    /**
     * Create the event listener.
     */
    // public function __construct(userActivityService $userActivityService)
    // {
    //     // $this->userActivityService = $userActivityService;
    // }

        /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        DB::table('users')
        ->where('id', $event->user->id) // Pastikan `id` ada
        ->update([
            'last_login_at' => now(),
        ]);
    }
}
