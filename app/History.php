<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['type', 'content', 'extra'];

    public function scopeRecent($query)
    {
        return $query->Orderby('created_at', 'DESC');
    }
}
