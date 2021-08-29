<?php

namespace App\Http\Controllers;

use App\Business_unit;
use Illuminate\Http\Request;
use App\Category;
use App\Company;
use App\User;

class CategoryController extends Controller
{
    public function index()
    {
        // Mendapatkan data Category berdasarkan User Company ID dari helper
        $category = Category::whereHas('business_unit', function ($q) {
            return $q->where('company_id', userCompanyId(auth()->user()->id));
        });

        if (getUserRoleScope() == "Business Unit") {
            $category->where('business_unit_id', userBusinessUnitId(auth()->user()->id));
        }

        if (getUserRoleScope() == "Branch") {
            $category->where('business_unit_id', userBusinessUnitId(auth()->user()->id));
        }

        $categories = $category->with('business_unit')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Mendapatkan data Business Unit berdasarkan User Company ID
        $business_unit = Business_unit::where('company_id', userCompanyId(auth()->user()->id));

        if (getUserRoleScope() == "Business Unit") {
            $business_unit->where('id', userBusinessUnitId(auth()->user()->id));
        }

        if (getUserRoleScope() == "Branch") {
            $business_unit->where('id', userBusinessUnitId(auth()->user()->id));
        }

        $business_units = $business_unit->orderBy('business_unit_name', 'ASC')->get();

        return response()->json([
            'data' => $business_units,
        ]);
    }

    public function store(Request $request)
    {
        //Validasi Request
        $this->validate($request, [
            'category_name' => 'required|string|max:50',
            'business_unit_id' => 'required|exists:business_units,id',
            'category_description' => 'nullable|string',
        ]);

        try {
            $categories = Category::firstOrCreate([
                'category_name' => $request->category_name,
                'business_unit_id' => $request->business_unit_id,
                'category_description' => $request->description
            ]);

            return redirect()->back()->with(['success' => $categories->category_name . ' Category Created']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // Mendapatkan data kategory berdasarkan ID kategori
        $categories = Category::findOrFail($id);

        $business_unit = Business_unit::where('company_id', userCompanyId(auth()->user()->id));

        if (getUserRoleScope() == "Business Unit") {
            $business_unit->where('id', userBusinessUnitId(auth()->user()->id));
        }

        if (getUserRoleScope() == "Branch") {
            $business_unit->where('id', userBusinessUnitId(auth()->user()->id));
        }

        $business_units = $business_unit->orderBy('business_unit_name', 'ASC')->get();

        return response()->json([
            'categories' => $categories,
            'business_units' => $business_units
        ]);
    }

    public function update(Request $request, $id)
    {
        //validasi form
        $this->validate($request, [
            'category_name' => 'required|string|max:50',
            'category_description' => 'nullable|string',
            'business_unit_id' => 'required|exists:business_units,id'
        ]);

        try {
            //select data berdasarkan id
            $categories = Category::findOrFail($id);
            //update data
            $categories->update([
                'category_name' => $request->category_name,
                'category_description' => $request->category_description,
                'business_unit_id' => $request->business_unit_id
            ]);

            //redirect ke route kategori.index
            return redirect(route('category.index'))->with(['success' => $categories->category_name . ' Category Updated']);
        } catch (\Exception $e) {
            //jika gagal, redirect ke form yang sama lalu membuat flash message error
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();
        return redirect()->back()->with(['success' => $categories->category_name . ' Category Deleted']);
    }
}
