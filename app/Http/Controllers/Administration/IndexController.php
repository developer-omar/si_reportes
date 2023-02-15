<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\CompanyInstitution;
use Illuminate\Http\Request;

class IndexController extends Controller {
    public function index() {
        $companiesInstitutions = CompanyInstitution::get();
        return view(
            'administration.index.index',
            [
                "companiesInstitutions" => $companiesInstitutions,
                "numCompaniesInstitutions" => \count($companiesInstitutions->toArray())
            ]
        );
    }
}
