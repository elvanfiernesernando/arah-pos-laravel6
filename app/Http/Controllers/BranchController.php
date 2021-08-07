<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Business_unit;

class BranchController extends Controller
{

    public function index()
    {
        if (getUserRoleScope() == "Company") {
            $branch = Branch::whereHas('business_unit', function ($q) {
                return $q->where('company_id', userCompanyId());
            });
        }

        if (getUserRoleScope() == "Business Unit") {
            $branch = Branch::whereHas('business_unit', function ($q) {
                return $q->where('id', userBusinessUnitId());
            });
        }

        if (getUserRoleScope() == "Branch") {
            $branch = Branch::whereHas('business_unit', function ($q) {
                return $q->where('id', userBusinessUnitId());
            });
        }

        $branches = $branch->orderBy('branch_name', 'ASC')->get();

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        // Mendapatkan data Business Unit
        $business_unit = Business_unit::where('company_id', userCompanyId());

        if (getUserRoleScope() == "Business Unit") {
            $business_unit->where('id', userBusinessUnitId());
        }

        if (getUserRoleScope() == "Branch") {
            $business_unit->where('id', userBusinessUnitId());
        }

        $business_units = $business_unit->orderBy('business_unit_name', 'ASC')->get();

        return response()->json([
            'data' => $business_units,
        ]);
    }

    public function store(Request $request)
    {
        //validasi form
        $this->validate($request, [
            'branch_name' => 'required|string|max:50',
            'branch_address' => 'required|string',
            'business_unit_id' => 'required||exists:business_units,id'
        ]);

        try {

            $branch = Branch::firstOrCreate([
                'branch_name' => $request->branch_name,
                'branch_address' => $request->branch_address,
                'business_unit_id' => $request->business_unit_id
            ]);

            return redirect()->back()->with(['success' => $branch->branch_name . ' Created']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        //query select berdasarkan id
        $branches = Branch::findOrFail($id);

        // Mendapatkan data Business Unit
        $business_unit = Business_unit::where('company_id', userCompanyId());

        if (getUserRoleScope() == "Business Unit") {
            $business_unit->where('id', userBusinessUnitId());
        }

        if (getUserRoleScope() == "Branch") {
            $business_unit->where('id', userBusinessUnitId());
        }

        $business_units = $business_unit->orderBy('business_unit_name', 'ASC')->get();

        return response()->json([
            'business_units' => $business_units,
            'branches' => $branches
        ]);
    }

    public function update(Request $request, $id)
    {
        //validasi
        $this->validate($request, [
            'branch_name' => 'required|string|max:100',
            'branch_address' => 'required|string|max:100',
            'business_unit_id' => 'required|exists:business_units,id'
        ]);

        try {
            //query select berdasarkan id
            $branch = Branch::findOrFail($id);

            //perbaharui data di database
            $branch->update([
                'branch_name' => $request->branch_name,
                'branch_address' => $request->branch_address,
                'business_unit_id' => $request->business_unit_id
            ]);


            return redirect(route('outlet.index'))->with(['success' => '<strong>' . $branch->branch_name . '</strong>  Updated']);
        } catch (\Exception $e) {
            return redirect(route('outlet.index'))->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $branches = Branch::findOrFail($id);
        $branches->delete();
        return redirect()->back()->with(['success' => $branches->branch_name . ' Deleted']);
    }
}
