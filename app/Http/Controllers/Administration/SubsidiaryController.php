<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubsidiaryValidation;
use App\Models\City;
use App\Models\CompanyInstitution;
use App\Models\Report;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubsidiaryController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $authenticatedUser = Auth::user();
            if (!$authenticatedUser->hasPermissionTo('subsidiary', 'user-administration'))
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
//        $authenticatedUser = Auth::user();
//        if(!$authenticatedUser->hasPermissionTo('subsidiary'))
//            return response()->view(
//                'common.errors.403',
//                [
//                    'layout' => 'administrator.layout.app'
//                ],
//                403
//            );

        //get companies / institutions
        $companiesInstitutions = CompanyInstitution::where('deleted_state', '=', 0)
            ->orderBy('name', 'asc')
            ->get();

        //get cities
        $cities = City::get();

        $subsidiaries = Subsidiary::with([
            'companyInstitution' => function($query) {
                $query->select('id', 'name');
            },
            'city' => function($query) {
                $query->select('id', 'name');
            },
        ]);
        //for search parameters
        $searchForm = $request->query();
        if(count($searchForm) > 0) {
            if(array_key_exists('name', $searchForm)) {
                $name = trim($searchForm['name']);
                if($name != '')
                    $subsidiaries = $subsidiaries->where(
                        'name', 'like', "%$name%"
                    );
            }
            if(array_key_exists('company_institution', $searchForm)) {
                $companyInstitution = $searchForm['company_institution'];
                if($companyInstitution != '')
                    $subsidiaries = $subsidiaries->where(
                        'company_institution_id', '=', $companyInstitution
                    );
            }
            if(array_key_exists('city', $searchForm)) {
                $city = $searchForm['city'];
                if($city != '')
                    $subsidiaries = $subsidiaries->where(
                        'city_id', '=', $city
                    );
            }

        }
        /*------------------------------------------------------------------*/
        $subsidiaries = $subsidiaries->orderBy('created_at', 'desc');
        $subsidiaries = $subsidiaries->paginate(20);
        return view('administration.subsidiary.index', [
            'companiesInstitutions' => $companiesInstitutions,
            'cities' => $cities,
            'subsidiaries' => $subsidiaries,
            'searchForm' => $searchForm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
//        $authenticatedUser = Auth::user();
//        if(!$authenticatedUser->hasPermissionTo('subsidiary'))
//            return response()->view(
//                'common.errors.403',
//                [
//                    'layout' => 'administrator.layout.app'
//                ],
//                403
//            );

        $cities = City::get();
        $companiesinstitutions = CompanyInstitution::where('deleted_state', '=', 0)
            ->orderBy('name', 'asc')
            ->get();
        $data = [
            'cardWidth' => 6,
            'title' => 'Adicionar Sucursal',
            'button' => 'Registrar',
            'action' => route('administration.subsidiary.store'),
            'cities' => $cities,
            'companiesInstitutions' => $companiesinstitutions
        ];
        return view('administration.subsidiary.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubsidiaryValidation $request) {
        try{
            $subsidiary = new Subsidiary();
            $subsidiary->name = $request->input('name');
            $subsidiary->company_institution_id = $request->input('company_institution_id');
            $subsidiary->city_id = $request->input('company_institution_id');
            $subsidiary->save();
            $request->session()->flash('store', true);
            return redirect()->route('administration.subsidiary.index');
        }catch (\Exception $e) {
            echo $e->getMessage();
            //return redirect()->route('administration.subsidiary.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try{
            $subsidiaries = Subsidiary::with([
                'city' => function($query) {
                    $query->select('id', 'name');
                }
            ])
                ->where('company_institution_id', '=', $id)
                ->where('deleted_state', '=', 0)
                ->orderBy('name', 'asc')
                ->get();
            if($subsidiaries->count() > 0)
                return response()->json($subsidiaries);
            else
                return response()->json([]);
        }catch (\Exception $e) {
            return response()->json([]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $subsidiary = Subsidiary::where('id', '=', $id)
            ->where('deleted_state', '=', 0)
            ->first();
        if(!is_null($subsidiary)) {
            $companiesInstitutions = CompanyInstitution::where('deleted_state', '=', 0)
                ->get();
            $cities = City::get();
            $data = [
                'cardWidth' => 6,
                'title' => 'Editar Sucursal',
                'action' => route('administration.subsidiary.update', ['id' => $id]),
                'method' => 'PUT',
                'subsidiary' => $subsidiary,
                'button' => 'Actualizar',
                'companiesInstitutions' => $companiesInstitutions,
                'cities' => $cities,
            ];
            return view('administration.subsidiary.form', $data);
        } else {
            return response()->view(
                'common.errors.404',
                [
                    'layout' => 'administration.layout.app'
                ],
                404
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubsidiaryValidation $request, $id) {
        try {
            $subsidiary = Subsidiary::where('id', '=', $id)
                ->where('deleted_state', '=', 0)
                ->first();
            if(!is_null($subsidiary)) {
                $subsidiary->name = $request->input('name');
                $subsidiary->company_institution_id = $request->input('company_institution_id');
                $subsidiary->city_id = $request->input('city_id');
                $subsidiary->save();
                $request->session()->flash('update', true);
                return redirect()->route('administration.subsidiary.index');
            } else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.app'
                    ],
                    404
                );
            }
        }catch (\Exception $e) {
            return redirect()->route('administration.subsidiary.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        try {
            $subsidiary = Subsidiary::where('id', '=', $id)
                ->where('deleted_state', '=', 0)
                ->first();
            if(!is_null($subsidiary)) {
                $reports = Report::where('subsidiary_id', '=', $subsidiary->id)
                    ->get();
                if($reports->count() > 0) {
                    $subsidiary->deleted_state = 1;
                    $subsidiary->save();
                } else {
                    $subsidiary->delete();
                }
                $request->session()->flash('destroy', true);
                return redirect()->route('administration.subsidiary.index');
            } else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.app'
                    ],
                    404
                );
            }
        }catch (\Exception $e) {
            return redirect()->route('subsidiary.index');
        }
    }

    public function restore(Request $request, $id) {
        try {
            $subsidiary = Subsidiary::find($id);
            if(!is_null($subsidiary)) {
                if($subsidiary->deleted_state == 1) {
                    $subsidiary->deleted_state = 0;
                    $subsidiary->save();
                    $request->session()->flash('update', true);
                }
                return redirect()->route('administration.subsidiary.index');
            } else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.app'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            echo 'error';
        }
    }
}
