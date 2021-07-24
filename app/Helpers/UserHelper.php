<?php

use Illuminate\Support\Facades\DB;
use App\Company;
use App\Business_unit;
use App\Branch;
use App\User;
use Illuminate\Support\Facades\Auth;

function userCompanyId()
{

    $user_company = Company::whereHas('business_units', function ($q) {
        return $q->whereHas('branches', function ($q) {
            return $q->whereHas('users', function ($q) {
                return $q->where('user_id', auth()->user()->id);
            });
        });
    });

    $user_company_id = $user_company->get()->pluck('id')->first();
    return $user_company_id;
}

function userCompanyStatus()
{
    $user_company = Company::whereHas('business_units', function ($q) {
        return $q->whereHas('branches', function ($q) {
            return $q->whereHas('users', function ($q) {
                return $q->where('user_id', auth()->user()->id);
            });
        });
    });

    $user_company_status = $user_company->get()->pluck('status')->first();
    return $user_company_status;
}

function userBusinessUnitId()
{
    $user_business_unit = Business_unit::whereHas('branches', function ($q) {
        return $q->whereHas('users', function ($q) {
            return $q->where('user_id', auth()->user()->id);
        });
    });

    $user_business_unit_id = $user_business_unit->get()->pluck('id')->first();
    return $user_business_unit_id;
}

function userBranchId()
{
    $user_branch = Branch::whereHas('users', function ($q) {
        return $q->where('user_id', auth()->user()->id);
    });

    $user_branch_id = $user_branch->get()->pluck('id')->first();
    return $user_branch_id;
}

function userIsProfileCompleted()
{
    $user_is_profile_completed = User::where('id', auth()->user()->id)->pluck('is_profile_completed')->first();
    return $user_is_profile_completed;
}
