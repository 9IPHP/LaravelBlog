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
        $existPermissionId = $this->permissions->fetch('id')->toArray();
        if(!in_array($permission_id, $existPermissionId))
            return $this->permissions()->attach([$permission_id]);
    }
}
