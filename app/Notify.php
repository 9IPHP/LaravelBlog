<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Notify extends Model
{
    protected $fillable = ['user_id', 'body', 'type', 'to_all'];

    public static function notify($user_id, $body, $type, $to_all = 0)
    {
        if ($user_id == auth()->id()) {
            return;
        }
        Notify::create([
            'user_id' => $user_id,
            'body' => $body,
            'type' => $type,
            'to_all' => $to_all
        ]);
        if ($to_all) {
            User::all()->increment('notice_count');
        }else{
            User::whereId($user_id)->increment('notice_count');
        }
    }
}
