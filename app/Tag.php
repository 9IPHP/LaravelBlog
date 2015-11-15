<?php

namespace App;

use App\Article;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public $timestamps = true;

    public function articles()
    {
        $this->belongsToMany(Article::class);
    }
}
