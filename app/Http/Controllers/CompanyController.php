<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Business_unit;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        // Mendapatkan User Company ID
        $user_company_id = userCompanyId();

        // Mendapatkan data company berdasarkan company id
        $companies = Company::findOrFail($user_company_id);

        // Mendapatkan data business berdasarkan company id
        $business_units = Business_unit::where('company_id', $user_company_id)->get();

        // Mendapatkan data branch berdasarkan adalah company_id yang berada di tabel business_unit
        $branches = Branch::whereHas('business_unit', function ($q) {

            // Mendapatkan User Company ID
            $user_company_id = userCompanyId();

            return $q->where('company_id', $user_company_id);
        })->get();

        return view('companies.index', compact('companies', 'business_units', 'branches'));
    }
}
