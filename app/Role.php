<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    //给角色添加权限
    public function assignPermission($permission_id)
    {
        return $this->permissions()->sync([$permission_id]);
    }
}
