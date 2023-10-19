<?php

namespace App\Http\Controllers;

use App\Models\notifications;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readNotification(string $id)
    {
        $notification = notifications::find($id);
        $notification->isRead = "sudah dibaca";
        $notification->save();
        return response()->json([
            "success" => true,
        ]);
    }
}
