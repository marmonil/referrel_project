<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\user;

use Svg\Tag\Rect;

class RollManagerController extends Controller
{
    function role_manager()
    {
        $all_user = user::all();
        $all_permisions = Permission::all();
        $all_roles = Role::all();
        return view('admin.role.role_manager', [
            'all_permisions' => $all_permisions,
            'all_roles' => $all_roles,
            'all_user' => $all_user,

        ]);
    }
    function add_permision(Request $request)
    {
        Permission::create(['name' => $request->permision_name]);
        return back();
    }
    function add_role(Request $request)
    {
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permision);
        return back();
    }
    function assign_role(Request $request)
    {
        $user = user::find($request->user_id);
        $user->assignRole($request->role_id);
        return back();
    }
    function edit_permission($user_id)
    {
        $all_permisions = Permission::all();
        $user_info = user::find($user_id);
        return view('admin.role.edit_permission', [
            'all_permisions' => $all_permisions,
            'user_info' =>  $user_info,
        ]);
    }
    function update_permission(Request $request)
    {
        $user = user::find($request->user_id);
        $user->syncPermissions($request->permission);
        return back();
    }
    function remove_role($user_id)
    {
        $user = user::find($user_id);
        $user->roles()->detach();
        $user->syncPermissions([]);
        return back();
    }
    function edit_role($role_id)
    {
        $role = Role::find($role_id);
        $all_permisions = Permission::all();
        return view('admin.role.edit_role', [
            'role' => $role,
            'all_permisions' => $all_permisions,
        ]);
    }
    function update_role(Request $request)
    {

        $role = Role::find($request->role_id);
        $role->syncPermissions($request->permission);
        return back();
    }
}
