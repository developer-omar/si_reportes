<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyInstitution;
use Illuminate\Support\Facades\Auth;

class CompanyInstitutionController extends Controller {

    public function index() {
        $userCompanyInstitution = Auth::guard('user-company-institution')->user();
        $userAdministration = Auth::guard('user-administration')->user();
        if(is_null($userCompanyInstitution) && is_null($userAdministration)) {
            $companiesInstitutions = CompanyInstitution::get();
            return view(
                'page.company-institution.index',
                [
                    "companiesInstitutions" => $companiesInstitutions,
                    "numCompaniesInstitutions" => \count($companiesInstitutions->toArray())
                ]
            );
        } else {
            if(!is_null($userCompanyInstitution))
                return redirect()->route('page.report.index');
            if(!is_null($userAdministration))
                return redirect()->route('administration.index.index');
        }
    }
}
