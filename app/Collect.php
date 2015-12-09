<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $fillable = ['user_id'];

    public function markable()
    {
        return $this->morphTo();
    }

    public function scopeByUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
