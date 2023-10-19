<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifications extends Model
{
    use HasFactory;
    protected $table = "notifications";
    protected $fillable = [
        "user_id",
        "sender_id",
        "status",
        "pesan"
    ];
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function sender()
    {
        return $this->belongsTo(User::class, "sender_id");
    }
    public function isRead()
    {
        return notifications::where('id', $this->id)->where('status', 'sudah dibaca')->exists();
    }
}

