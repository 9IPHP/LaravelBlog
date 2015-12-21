<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'website', 'weibo', 'github', 'qq', 'description', 'role_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function collects()
    {
        return $this->belongsToMany(Article::class, 'collects')->withTimestamps();
    }

    public function owns($related, $foreign_key = 'user_id')
    {
        return $this->id === $related->$foreign_key;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // 判断用户是否具有某个角色
    public function hasRole($role)
    {
        if (is_null($role)) {
            return false;
        }
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    public function userCan($permission = null)
    {
        return !is_null($permission) && $this->hasPermission($permission);
    }


    // 判断用户是否具有某权限
    public function hasPermission($permission)
    {
        if (is_null($permission)) {
            return false;
        }
        if (is_string($permission)) {
            $permission = Permission::whereSlug($permission)->firstOrFail();
        }
        return $this->hasRole($permission->roles);
    }

    // 给用户分配角色
    public function assignRole($role_id)
    {
        return $this->roles()->sync([$role_id]);
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
