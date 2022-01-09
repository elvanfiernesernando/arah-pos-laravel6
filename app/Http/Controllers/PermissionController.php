<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Spatie\Permission\Models\Permission;
use DB;

class PermissionController extends Controller
{
    public function rolePermission(Request $request)
    {
        $role = $request->get('role');

        //Default, set dua buah variable dengan nilai null
        $permissions = null;
        $hasPermission = null;
        $getRole = null;

        //Mengambil data role
        $roles = Role::where('company_id', userCompanyId(auth()->user()->id))->get();

        //apabila parameter role terpenuhi
        if (!empty($role)) {
            //select role berdasarkan namenya, ini sejenis dengan method find()
            $getRole = Role::where('name', $role)->where('company_id', userCompanyId(auth()->user()->id))->first();

            //Query untuk mengambil permission yang telah dimiliki oleh role terkait
            $hasPermission = DB::table('role_has_permissions')
                ->select('permissions.name')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->where('role_id', $getRole->id)->get()->pluck('name')->all();

            //Mengambil data permission
            $permissions = Permission::all()->pluck('name');
        }
        return view('permissions.index
        ', compact('roles', 'permissions', 'hasPermission', 'getRole'));
    }

    public function addPermission(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:permissions',
        ]);

        $permission = Permission::firstOrCreate([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    public function setRolePermission(Request $request, $role)
    {
        //select role berdasarkan namanya
        $role = Role::where('name', $role)->where('company_id', userCompanyId(auth()->user()->id))->first();

        //fungsi syncPermission akan menghapus semua permissio yg dimiliki role tersebut
        //kemudian di-assign kembali sehingga tidak terjadi duplicate data
        $role->syncPermissions($request->permission);

        $role->update([
            'scope' => $request->scope,
        ]);
        return redirect()->back()->with(['success' => 'Permission to Role Saved!']);
    }
}
