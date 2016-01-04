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

    public function scopeWhereBody($query, $body)
    {
        if($body){
            return $query->where('body', 'like', '%'.$body.'%');
        }
        return $query;
    }
}
