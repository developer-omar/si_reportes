<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\CompanyInstitution;
use Illuminate\Http\Request;

class IndexController extends Controller {
    public function index() {
        $companiesInstitutions = CompanyInstitution::get();
        //dd($companiesInstitutions->toArray());
        return view(
            'page.index.index',
            [
                "companiesInstitutions" => $companiesInstitutions,
                "numCompaniesInstitutions" => \count($companiesInstitutions->toArray())
            ]
        );
    }
}
