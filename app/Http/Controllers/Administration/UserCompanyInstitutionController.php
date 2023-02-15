<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCompanyInstitutionValidation;
use App\Models\CompanyInstitution;
use App\Models\User;
use App\Models\UserCompanyInstitution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserCompanyInstitutionController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $authenticatedUser = Auth::user();
            if (!$authenticatedUser->hasPermissionTo('user_company_institution', 'user-administration'))
                return response()->view(
                    'common.errors.403',
                    [
                        'layout' => 'administration.layout.dashboard'
                    ],
                    403
                );
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        //get url parameters
        $searchForm = $request->query();

        //get companies / institutions
        $companiesInstitutions = CompanyInstitution::where('deleted_state', '=', 0)
            ->orderBy('name', 'asc')
            ->get();

        //make sql for get users company institutions
        $usersCompanyInstitution = UserCompanyInstitution::with([
            'companyInstitution' => function($query) {
                $query->select('id', 'name');
            }
        ]);

        if(count($searchForm) > 0) {
            //sql for name
            if(array_key_exists('name', $searchForm)) {
                if (trim($searchForm['name']) != '') {
                    $usersCompanyInstitution = $usersCompanyInstitution->where(
                        'name', 'like',
                        "%" . trim($searchForm['name']) . "%"
                    );
                }
            }

            //sql for last name
            if(array_key_exists('last_name', $searchForm)) {
                if (trim($searchForm['last_name']) != '') {
                    $usersCompanyInstitution = $usersCompanyInstitution->where(
                        'last_name', 'like',
                        "%" . trim($searchForm['last_name']) . "%"
                    );
                }
            }

            //sql for last name
            if(array_key_exists('company_institution', $searchForm)) {
                if (trim($searchForm['company_institution']) != '') {
                    $usersCompanyInstitution = $usersCompanyInstitution->where(
                        'company_institution_id', '=',
                        trim($searchForm['company_institution'])
                    );
                }
            }
        }
        $usersCompanyInstitution = $usersCompanyInstitution->paginate(20);
        $data = [
            'searchForm' => $searchForm,
            'companiesInstitutions' => $companiesInstitutions,
            'usersCompanyInstitution' => $usersCompanyInstitution
        ];
        return view('administration.user-company-institution.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $companiesInstitutions = CompanyInstitution::where('deleted_state', '=', 0)
            ->orderBy('name', 'asc')
            ->get();
        $data = [
            'cardWidth' => 6,
            'title' => 'Adicionar Usuario Emp. / Inst.',
            'button' => 'Registrar',
            'action' => route('administration.user-company-institution.store'),
            'companiesInstitutions' => $companiesInstitutions,
        ];
        return view('administration.user-company-institution.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCompanyInstitutionValidation $request) {
        try {
            $userCompanyInstitution = new UserCompanyInstitution();
            $userCompanyInstitution->name = $request->input('name');
            $userCompanyInstitution->last_name = $request->input('last_name');
            $userCompanyInstitution->company_institution_id = $request->input('company_institution_id');
            $userCompanyInstitution->email = $request->input('email');
            $userCompanyInstitution->password = Hash::make($request->input('password'));
            $userCompanyInstitution->save();
            $request->session()->flash('store', true);
            return redirect()->route('administration.user-company-institution.index');
        } catch (\Exception $e) {
            return redirect()->route('administration.user-company-institution.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        try {
            $userCompanyInstitution = UserCompanyInstitution::find($id);
            if(!is_null($userCompanyInstitution)) {
                $companiesInstitutions = CompanyInstitution::where('deleted_state', '=', 0)
                    ->orderBy('name', 'asc')
                    ->get();
                $data = [
                    'cardWidth' => 6,
                    'title' => 'Editar Usuario Emp. / Inst.',
                    'action' => route('administration.user-company-institution.update', ['id' => $id]),
                    'method' => 'PUT',
                    'userCompanyInstitution' => $userCompanyInstitution,
                    'companiesInstitutions' => $companiesInstitutions,
                    'button' => 'Actualizar',
                ];
                return view('administration.user-company-institution.form', $data);
            } else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.dashboard'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserCompanyInstitutionValidation $request, $id) {
        try {
            $userCompanyInstitution = UserCompanyInstitution::find($id);
            if(!is_null($userCompanyInstitution)) {
                $userCompanyInstitution->name = $request->input('name');
                $userCompanyInstitution->last_name = $request->input('last_name');
                $userCompanyInstitution->company_institution_id = $request->input('company_institution_id');
                $userCompanyInstitution->email = $request->input('email');
                $password = $request->input('password');
                if(!is_null($password))
                    $userCompanyInstitution->password = Hash::make(trim($password));
                $userCompanyInstitution->save();
                $request->session()->flash('update', true);
                return redirect()->route('administration.user-company-institution.index');
            } else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.dashboard'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {
        try {
            $userCompanyInstitution = UserCompanyInstitution::find($id);
            if(!is_null($userCompanyInstitution)) {
                $userCompanyInstitution->delete();
                $request->session()->flash('destroy', true);
                return redirect()->route('administration.user-company-institution.index');
            } else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.dashboard'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
