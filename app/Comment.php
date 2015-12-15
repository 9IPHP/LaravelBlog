<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'body'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent($query)
    {
        return $query->Orderby('created_at', 'DESC');
    }

    protected function atParse($comment)
    {
        $atUsers = [];
        preg_match_all("/(\S*)\@([^\r\n\s]*)/i", $comment, $atUsers);
        $usernames = [];
        foreach ($atUsers[2] as $k=>$v) {
            if ($atUsers[1][$k] || strlen($v) >25) {
                continue;
            }
            $usernames[] = $v;
        }
        $usernames = array_unique($usernames);
        if (count($usernames)){
            $users = User::whereIn('name', $usernames)->get();
            if($users) foreach ($users as $user) {
                $search = '@' . $user->name;
                // $place = '<a href="'.route('user.show', $user->id).'" target="_blank" title="'.$user->name.'" data-toggle="tooltip">'.$search.'</a>';
                $place = '['.$search.']('.route('user.show', $user->id).' "'.$user->name.'")';
                $comment = str_replace($search, $place, $comment);
            }
        }
        return $comment;
    }
}
