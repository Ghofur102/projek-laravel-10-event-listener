<?php

namespace App\Http\Controllers;

use App\Events\UserFollowed;
use App\Events\UserUnfollowed;
use App\Models\followers;
use App\Models\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function process_follow(string $follow_id, string $sender_id)
    {
        $check = followers::where("follower_id", $follow_id)->where("following_id", $sender_id)->exists();
        if ($check) {
            $delete = followers::where("follower_id", $follow_id)->where("following_id", $sender_id)->first();
            $delete->delete();
            event(new UserUnfollowed(User::find($follow_id), User::find($sender_id)));
            return response()->json([
                "success" => true,
                "follow" => false,
                "message" => "Anda berhasil membatalkan mengikuti!"
            ]);
        } else {
            followers::create([
                "follower_id" => $follow_id,
                "following_id" => $sender_id
            ]);
            $follower = User::find($follow_id);
            $following = User::find($sender_id);
            event(new UserFollowed($follower, $following));
            return response()->json([
                "success" => true,
                "follow" => true,
                "message" => "Anda berhasil mengikuti!"
            ]);
        }
    }
}
