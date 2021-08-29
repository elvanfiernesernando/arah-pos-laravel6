<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business_unit;

class BusinessUnitController extends Controller
{

    public function index()
    {
        // Mendapatkan data business
        $business_unit = Business_unit::where('company_id', userCompanyId(auth()->user()->id));

        if (getUserRoleScope() == "Business Unit") {
            $business_unit->where('id', userBusinessUnitId(auth()->user()->id));
        }

        if (getUserRoleScope() == "Branch") {
            $business_unit->where('id', userBusinessUnitId(auth()->user()->id));
        }

        $business_units = $business_unit->orderBy('business_unit_name', 'ASC')->get();

        return view('business_units.index', compact('business_units'));
    }

    public function store(Request $request)
    {
        //validasi form
        $this->validate($request, [
            'business_unit_name' => 'required|string|max:50',
            'business_type' => 'required|string',
        ]);

        try {

            // Mendapatkan User Company ID
            $user_company_id = userCompanyId(auth()->user()->id);

            $business_units = Business_unit::firstOrCreate([
                'business_unit_name' => $request->business_unit_name,
                'business_type' => $request->business_type,
                'company_id' =>  $user_company_id
            ]);

            return redirect()->back()->with(['success' => $business_units->business_unit_name . ' Created']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // Mendapatkan data business unit berdasarkan ID kategori
        $business_units = Business_unit::findOrFail($id);

        return response()->json([
            'business_units' => $business_units
        ]);
    }

    public function update(Request $request, $id)
    {
        //validasi form
        $this->validate($request, [
            'business_unit_name' => 'required|string|max:50',
            'business_type' => 'required|string',
        ]);

        try {
            //select data berdasarkan id
            $business_units = Business_unit::findOrFail($id);
            //update data
            $business_units->update([
                'business_unit_name' => $request->business_unit_name,
                'business_type' => $request->business_type
            ]);

            //redirect ke route kategori.index
            return redirect(route('business-unit.index'))->with(['success' => $business_units->business_unit_name . ' Updated']);
        } catch (\Exception $e) {
            //jika gagal, redirect ke form yang sama lalu membuat flash message error
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $business_units = Business_unit::findOrFail($id);
        $business_units->delete();
        return redirect()->back()->with(['success' => $business_units->business_unit_name . ' Deleted']);
    }
}
