<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['user_id', 'name', 'url', 'size'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
