<?php

namespace App;

use App\User;
use App\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'thumb', 'excerpt', 'body', 'comment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhose($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeWhereTitle($query, $title)
    {
        if ($title) {
            return $query->where('title', 'like', '%'.$title.'%');
        }
        return $query;
    }

    public function tags(){
        return $this->belongstoMany(Tag::class)->withTimestamps();
    }

    public function getTagListAttribute(){
        return $this->tags->lists('slug', 'name')->toArray();
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function collects()
    {
        return $this->belongsToMany(User::class, 'collects', 'article_id', 'user_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
