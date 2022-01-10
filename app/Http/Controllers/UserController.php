<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Branch;
use App\Business_unit;
use DB;

class UserController extends Controller
{
    public function index()
    {

        // Mendapatkan data user berdasarkan Company ID yang berada pada relationship user->branch->business_unit->company
        $user = User::whereHas('branch', function ($q) {
            return $q->whereHas('business_unit', function ($q) {
                return $q->where('company_id', userCompanyId(auth()->user()->id));
            });
        });

        $users = $user->whereHas("roles", function ($q) {
            $q->where("name", '!=', "Master");
        })->orderBy('created_at', 'ASC')->with('branch.business_unit')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $business_units = Business_unit::where('company_id', userCompanyId(auth()->user()->id))->orderBy('business_unit_name', 'ASC')->get();
        $roles = Role::where('company_id', userCompanyId(auth()->user()->id))->orderBy('name', 'ASC')->get();

        return response()->json([
            'data' => $roles,
            'business_units' => $business_units
        ]);
    }

    public function branch(Request $request)
    {
        $branches = Branch::where('business_unit_id', $request->id)->orderBy('branch_name', 'ASC')->get();

        return response()->json([
            'data' => $branches
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'branch_id' => 'required|exists:branches,id',
            'role_id' => 'required|exists:roles,id'
        ]);


        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'status' => 1,
                'is_profile_completed' => 1
            ]);

            // Kemudian Attach User ke Branch
            $user->branch()->attach($request->branch_id);

            $role = Role::where('id', $request->role_id)->get()->first();

            $user->assignRole($role);
            //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();

            return redirect(route('user.index'))->with(['success' => '<strong>' . $user->name . '</strong> Employee Created']);
        } catch (\Exception $e) {
            //jika ada error, maka akan dirollback sehingga tidak ada data yang tersimpan 
            DB::rollback();
            //jika gagal, kembali ke halaman sebelumnya kemudian tampilkan error
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);

        // Get business units data by company ID
        $business_units = Business_unit::where('company_id', userCompanyId(auth()->user()->id))->orderBy('business_unit_name', 'ASC')->get();
        // Variable dibawah digunakan sebagai pembanding untuk memunculkan class 'selected'
        $user_business_unit = Business_unit::whereHas('branches', function ($q) use ($id) {
            return $q->whereHas('users', function ($q) use ($id) {
                return $q->where('user_id', $id);
            });
        })->get()->first();

        // Get branches data by current business unit
        $branches = Branch::where('business_unit_id', $user_business_unit->id)->get();
        // Variable dibawah digunakan sebagai pembanding untuk memunculkan class 'selected'
        $user_branch = Branch::whereHas('users', function ($q) use ($id) {
            return $q->where('user_id', $id);
        })->get()->first();

        // Get all Roles data by Company ID
        $roles = Role::where('company_id', userCompanyId(auth()->user()->id))->orderBy('name', 'ASC')->get();
        // Variable dibawah digunakan sebagai pembanding untuk memunculkan class 'selected'
        $user_role = $users->roles()->first();

        return response()->json([
            'data' => $users,
            'business_units' => $business_units,
            'user_business_unit' => $user_business_unit,
            'branches' => $branches,
            'user_branch' => $user_branch,
            'roles' => $roles,
            'user_role' => $user_role,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|exists:users,email',
            'password' => 'nullable|min:6',
            'branch_id' => 'required|integer'
        ]);

        $users = User::findOrFail($id);
        $role = Role::findById($request->role_id);

        $password = !empty($request->password) ? bcrypt($request->password) : $users->password;
        $users->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        $users->branch()->sync([$request->branch_id]);

        $users->syncRoles($role);

        return redirect(route('user.index'))->with(['success' => 'User: <strong>' . $users->name . '</strong> Updated']);
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return redirect()->back()->with(['success' => 'User: <strong>' . $users->name . '</strong> Deleted']);
    }
}
