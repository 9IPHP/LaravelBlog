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
        'title', 'thumb', 'excerpt', 'body', 'is_active', 'comment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActived($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeWhose($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public function scopeRecent($query)
    {
        return $query->Orderby('created_at', 'DESC');
    }

    public function tags(){
        return $this->belongstoMany(Tag::class)->withTimestamps();
    }

    public function getTagListAttribute(){
        return $this->tags->lists('slug', 'name')->toArray();
    }

}
