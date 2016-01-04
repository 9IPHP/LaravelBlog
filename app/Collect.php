<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    public function user()
    {
        return $this->belongstoMany(User::class, 'collects');
    }

    public function article()
    {
        return $this->belongstoMany(Article::class, 'collects');
    }

    public static function isCollect(User $user, Article $article)
    {
        return Collect::where('user_id', $user->id)
                ->where('article_id', $article->id)
                ->first();
    }
}
