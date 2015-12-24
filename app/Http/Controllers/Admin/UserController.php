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
    public function index()
    {

        $users = User::with('roles')
                    ->Orderby('created_at', 'DESC')
                    ->paginate(10);
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function edit($id)
    {

    }

    public function update(Request $request)
    {
        $user_id = $request->user_id;
        $role_id = $request->role_id;
        $user = User::with('roles')->find($user_id, ['id']);
        $role = Role::find($role_id, ['id']);
        if (empty($user) || empty($role)) {
            return response()->json(404);
        }
        $roles = Role::orderBy('id', 'DESC')->get();
        // View::make()
        $user->assignRole($role->id);
        return response()->json(200);
        return response()->json($request->all());
    }

    public function roles()
    {
        $roles = Role::with('permissions')->orderBy('id', 'DESC')->get();
        return view('admin.users.roles', compact('roles'));
        dd($roles);
    }

    public function editRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::get(['id', 'name']);
        return view('admin.users.editrole', compact('role', 'permissions'));

        dd($permissions);
        dd($role->permissions);
    }

    public function updateRole($id, Request $request)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->permission_id);
        flash()->message('修改成功！');
        return redirect('admin/users/roles');
    }
}
