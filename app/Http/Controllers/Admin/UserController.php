<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use App\Permission;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('acl:user.manage');
    }

    public function index()
    {

        $users = User::with('roles')
                    ->Orderby('created_at', 'DESC')
                    ->paginate(10);
        $roles = Role::orderBy('id', 'DESC')->get(['id', 'name']);
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function edit($id)
    {

    }

    public function update(Request $request)
    {
        $user_id = $request->user_id;
        $role_id = $request->role_id;
        if($user_id == 1){
            return response()->json(['status' => 401, 'msg' => '不能修改超级管理员的用户组']);
        }
        $user = User::find($user_id, ['id']);
        $role = Role::find($role_id, ['id']);
        if (empty($user) || empty($role)) {
            return response()->json(['status' => 404, 'msg' => '用户或用户组不存在']);
        }
        $user->assignRole($role->id);

        $roles = Role::orderBy('id', 'DESC')->get(['id', 'name']);
        $html = view()->make('admin.users._user_roles', compact('roles', 'user'))->render();
        return response()->json(['status' => 200, 'html' => $html]);
    }

    public function roles()
    {
        $roles = Role::with('permissions')->orderBy('id', 'DESC')->get();
        return view('admin.users.roles', compact('roles'));
    }

    public function editRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::get(['id', 'name']);
        return view('admin.users.editrole', compact('role', 'permissions'));
    }

    public function updateRole($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $permission_id = $request->permission_id ? $request->permission_id : [];
        $role->permissions()->sync($permission_id);
        flash()->message('修改成功！');
        return redirect()->back();
        // return redirect('admin/users/roles');
    }
}
