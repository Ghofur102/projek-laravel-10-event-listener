<?php

namespace App\Listeners;

use App\Events\UserUnfollowed;
use App\Models\notifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteSendFollowNotification
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
    public function handle(UserUnfollowed $event): void
    {
        $follower = $event->follower;
        $following = $event->following;

        // menghapus notifikasi follow
        $notif = notifications::where("user_id", $follower->id)
        ->where("sender_id", $following->id)
        ->where("status", "follow")
        ->first();
        $delete = notifications::find($notif->id);
        $delete->delete();
    }
}
