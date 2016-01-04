<?php

namespace App;

use App\Article;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'letter'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function scopeWhereName($query, $name)
    {
        if($name){
            return $query->where('name', 'like', '%'.$name.'%');
        }
        return $query;
    }
}
