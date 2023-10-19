<?php

namespace App\Listeners;

use App\Events\UserFollowed;
use App\Models\notifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendFollowNotification
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
    public function handle(UserFollowed $event): void
    {
        $follower = $event->follower;
        $following = $event->following;

        // membuat notifikasi ke database secara manual!
        notifications::create([
            "user_id" => $follower->id,
            "sender_id" => $following->id,
            "status" => "follow",
            "pesan" => "Anda telah difollow oleh {$following->name}.",
        ]);

    }
}
