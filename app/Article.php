<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'thumb', 'excerpt', 'body', 'is_active', 'comment_status',
    ];

    public function user()
    {
        $this->belongTo(User::class);
    }

    public function scopeActived($query)
    {
        return $query->where('is_active', 1);
    }
}
