<?php
namespace App\Repositories;

use App\User;
use App\Follower;
use App\History;
use Auth;

class UserRepository{

    public function follow($u)
    {
        $user = Auth::user();
        if($user->id == $u->id){
            return 401;
        }
        if(User::isFollowing($user, $u)){
            $user->follows()->detach([$u->id]);
            $user->decrement('follows_count');
            $u->decrement('fans_count');
            $user->histories()->create([
                'type' => 'unfollow',
                'content' => '取消关注：<strong><a href="/user/'.$u->id.'" target="_blank">'.$u->name.'</a></strong>'
            ]);
            return -1;
        }else{
            $user->follows()->attach([$u->id]);
            $user->increment('follows_count');
            $u->increment('fans_count');
            $user->histories()->create([
                'type' => 'follow',
                'content' => '关注用户：<strong><a href="/user/'.$u->id.'" target="_blank">'.$u->name.'</a></strong>'
            ]);
            return 1;

        }
    }


}