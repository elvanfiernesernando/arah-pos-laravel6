<?php

use Illuminate\Support\Facades\DB;
use App\Company;
use App\Business_unit;
use App\Branch;
use App\User;
use Illuminate\Support\Facades\Auth;

function userCompanyId($id)
{

    $user_company = Company::whereHas('business_units', function ($q) use ($id) {
        return $q->whereHas('branches', function ($q) use ($id) {
            return $q->whereHas('users', function ($q) use ($id) {
                return $q->where('user_id', $id);
            });
        });
    });

    $user_company_id = $user_company->get()->pluck('id')->first();
    return $user_company_id;
}

function userCompanyStatus($id)
{
    $user_company = Company::whereHas('business_units', function ($q) use ($id) {
        return $q->whereHas('branches', function ($q) use ($id) {
            return $q->whereHas('users', function ($q) use ($id) {
                return $q->where('user_id', $id);
            });
        });
    });

    $user_company_status = $user_company->get()->pluck('status')->first();
    return $user_company_status;
}

function userBusinessUnitId($id)
{
    $user_business_unit = Business_unit::whereHas('branches', function ($q) use ($id) {
        return $q->whereHas('users', function ($q) use ($id) {
            return $q->where('user_id', $id);
        });
    });

    $user_business_unit_id = $user_business_unit->get()->pluck('id')->first();
    return $user_business_unit_id;
}

function userBranchId($id)
{
    $user_branch = Branch::whereHas('users', function ($q) use ($id) {
        return $q->where('user_id', $id);
    });

    $user_branch_id = $user_branch->get()->pluck('id')->first();
    return $user_branch_id;
}

function userIsProfileCompleted($id)
{
    $user_is_profile_completed = User::where('id', $id)->pluck('is_profile_completed')->first();
    return $user_is_profile_completed;
}

function getUserRoleScope()
{
    $role_scope = auth()->user()->roles->first()->scope;
    return $role_scope;
}
