<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('created_at', 'DESC')->where('company_id', userCompanyId(auth()->user()->id))->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'scope' => 'required|string|max:50'
        ]);

        $check_role = Role::where('name', $request->name)->where('company_id', userCompanyId(auth()->user()->id))->get()->first();

        if (empty($check_role)) {
            $role = Role::firstOrCreate([
                'name' => $request->name,
                'company_id' => userCompanyId(auth()->user()->id),
                'scope' => $request->scope
            ]);
            return redirect()->back()->with(['success' => '<strong>' . $role->name . '</strong> Role Created']);
        } else {
            return redirect()->back()->with(['error' => '<strong>' . $request->name . '</strong> Already Exist!']);
        }
    }

    public function destroy($id)
    {
        $roles = Role::findOrFail($id);
        $roles->delete();
        return redirect()->back()->with(['success' => '<strong>' . $roles->name . '</strong> Role Deleted']);
    }
}
