<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use App\Permission;
use App\Article;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('acl:user.manage');
    }

    public function index(Request $request)
    {
        $s = $request->s ? $request->s : '';

        $users = User::with('roles')
                    ->whereUser($s)
                    ->latest()
                    ->paginate(10);
        $roles = Role::orderBy('id', 'DESC')->get(['id', 'name']);
        return view('admin.users.index', compact('users', 'roles', 's'));
    }

    public function destroy($id)
    {
        if($id == 1){
            return response()->json(['status' => 401, 'msg' => '不能删除超级管理员']);
        }
        $user = User::find($id);
        if (empty($user)) {
            return response()->json(['status' => 404, 'msg' => '用户不存在']);
        }
        $articles = Article::whereUserId($id)->count();
        if($articles > 0){
            return response()->json(['status' => 403, 'msg' => '请先删除该用户的文章']);
        }
        $user->delete();
        return response()->json(['status' => 200, 'msg' => '删除成功']);
    }

    public function changeRole(Request $request)
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
