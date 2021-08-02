<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Branch;
use App\Business_unit;
use App\Company;
use DB;

class WizardController extends Controller
{
    public function index()
    {
        return view('auth.wizard');
    }

    public function store(Request $request)
    {
        //validasi data request yang masuk
        $this->validate($request, [
            // validasi bagian company
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|max:255|unique:companies,company_email',
            'company_phone' => 'nullable|string|max:255|unique:companies,company_phone',
            'company_address' => 'required|string|max:255',

            // validasi unit bisnis
            'business_unit_name' => 'required|string|max:255',
            'business_type' => 'required|string|max:100',

            // validasi branch
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
        ]);

        // Simpan data company
        //database transaction
        DB::beginTransaction();
        try {

            //Simpan data company
            $company = Company::create([
                'company_name' => $request->company_name,
                'company_email' => $request->company_email,
                'company_phone' => $request->company_phone,
                'company_address' => $request->company_address
            ]);

            // Simpan data unit bisnis
            $business_unit = Business_unit::create([
                'business_unit_name' => $request->business_unit_name,
                'business_type' => $request->business_type,
                'company_id' => $company->id
            ]);

            // Simpan data unit branch
            $branch = Branch::create([
                'branch_name' => $request->branch_name,
                'branch_address' => $request->branch_address,
                'business_unit_id' => $business_unit->id
            ]);

            // Ambil data user yang sedang login
            $user = User::findOrFail(auth()->user()->id);

            // Ambil data role master
            $master = Role::where('name', 'Master')->get();

            if ($master->isEmpty()) {
                $master_role = Role::create([
                    'name' => 'Master',
                    'company_id' => null,
                    'scope' => 'Company',
                ]);
                // Assign Role master ke User
                $user->first()->assignRole($master_role);
            } else {
                // Assign Role master ke User
                $user->assignRole($master);
            }

            // Find Cashier Role
            $cashier = Role::where('name', 'Cashier')->where('company_id', $company->id)->get();

            if ($cashier->isEmpty()) {
                $cashier_role = Role::create([
                    'name' => 'Cashier',
                    'company_id' => $company->id,
                    'scope' => 'Branch'
                ]);

                $cashier_role->givePermissionTo('Access Mobile Apps');
            }

            // Kemudian Attach User ke Branch
            $user->branch()->attach($branch->id);

            // Update kolom is_profile_completed
            $user->update([
                'is_profile_completed' => 1
            ]);

            //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();

            //jika berhasil direct ke produk.index
            return redirect('home')->with(['success' => 'Congratulations! you have completed the registration wizard. Now you can use our service']);
        } catch (\Exception $e) {
            //jika ada error, maka akan dirollback sehingga tidak ada data yang tersimpan 
            DB::rollback();
            //jika gagal, kembali ke halaman sebelumnya kemudian tampilkan error
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
