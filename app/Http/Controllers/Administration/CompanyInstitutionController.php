<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyInstitutionValidation;
use App\Models\CompanyInstitution;
use App\Models\Subsidiary;
use App\Traits\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CompanyInstitutionController extends Controller {
    use Helpers;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $authenticatedUser = Auth::user();
            if (!$authenticatedUser->hasPermissionTo('company_institution', 'user-administration'))
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
        $companiesInstitutions = CompanyInstitution::orderBy('name', 'asc');
        $searchForm = $request->query();
        if(count($searchForm) > 0) {
            if(array_key_exists('name', $searchForm)) {
                $name = trim($searchForm['name']);
                if($name != '')
                    $companiesInstitutions = $companiesInstitutions->where(
                        'name', 'like', "%$name%"
                    );
            }
        }
        $companiesInstitutions = $companiesInstitutions->paginate(20);
        return view('administration.company-institution.index', [
            'companiesInstitutions' => $companiesInstitutions,
            'searchForm' => $searchForm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'cardWidth' => 8,
            'title' => 'Adicionar Empresa / Instituci&oacute;n',
            'button' => 'Registrar',
            'action' => route('administration.company-institution.store')
        ];
        return view('administration.company-institution.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyInstitutionValidation $request) {
        try{
            $companyInstitution = new CompanyInstitution();
            $companyInstitution->name = $request->input('name');
            //generate random name for image
            $photo = $request->file('photo');
            $photoName = $this->getRandomName() . '.' . $photo->extension();
            //-----------------------------------------------------
            $baseUrl = URL::to('/');
            $companyInstitution->photo = $baseUrl . '/storage/companies_institutions/' . $photoName;
            $companyInstitution->save();
            //save cover in storage
            $photo->storeAs(
                'companies_institutions',
                $photoName,
                'public'
            );
            $request->session()->flash('store', true);
            return redirect()->route('administration.company-institution.index');
        }catch (\Exception $e) {
            return redirect()->route('administration.company-institution.index');
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
        $companyInstitution = CompanyInstitution::where('id', '=', $id)
            ->where('deleted_state', '=', 0)
            ->first();
        if(!is_null($companyInstitution)){
            $data = [
                'cardWidth' => 8,
                'title' => 'Editar Empresa / Instituci&oacute;n',
                'action' => route('administration.company-institution.update', ['id' => $id]),
                'method' => 'PUT',
                'companyInstitution' => $companyInstitution,
                'button' => 'Actualizar',
            ];
            return view('administration.company-institution.form', $data);
        } else {
            return response()->view(
                'common.errors.404',
                [
                    'layout' => 'administration.layout.dashboard'
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
    public function update(CompanyInstitutionValidation $request, $id) {
        try {
            $companyInstitution = CompanyInstitution::where('id', '=', $id)
                ->where('deleted_state', '=', 0)
                ->first();
            if(!is_null($companyInstitution)) {
                $photo = $request->file('photo');
                if(!is_null($photo)) {
                    //get photo name for delete
                    $arrayPhotoDb = explode('/', $companyInstitution->photo);
                    $photoDb = $arrayPhotoDb[count($arrayPhotoDb) -1];
                    //update photo name
                    $photoName = $this->getRandomName('photo') . '.' . $photo->extension();
                    $baseUrl = URL::to('/');
                    $companyInstitution->photo = $baseUrl . '/storage/companies_institutions/' . $photoName;
                }
                $companyInstitution->name = $request->input('name');
                $companyInstitution->save();
                //save photo in storage
                if(!is_null($photo)) {
                    //save new photo
                    $photo->storeAs(
                        'companies_institutions',
                        $photoName,
                        'public'
                    );
                    //delete photo
                    Storage::disk('public')->delete('companies_institutions/' . $photoDb);
                }
                $request->session()->flash('update', true);
                return redirect()->route('administration.company-institution.index');
            }else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.dashboard'
                    ],
                    404
                );
            }
        }catch (\Exception $e) {
            echo 'error';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $companyInstitution = CompanyInstitution::where('id', '=', $id)
            ->where('deleted_state', '=', 0)
            ->first();
        if(!is_null($companyInstitution)) {
            $subsidiaries = Subsidiary::where('company_institution_id', '=', $companyInstitution->id)
                ->get();
            if($subsidiaries->count() > 0) {
                $companyInstitution->deleted_state = 1;
                $companyInstitution->save();
            } else {
                //delete file
                $arrayPhotoDb = explode('/', $companyInstitution->photo);
                $fileDb = $arrayPhotoDb[count($arrayPhotoDb) -1];
                Storage::disk('public')->delete('companies_institutions/' . $fileDb);
                $companyInstitution->delete();
            }
            $request->session()->flash('destroy', true);
            return redirect()->route('administration.company-institution.index');
        } else {
            return response()->view(
                'common.errors.404',
                [
                    'layout' => 'administration.layout.dashboard'
                ],
                404
            );
        }
    }

    public function restore(Request $request, $id) {
        try {
            $companyInstitution = CompanyInstitution::find($id);
            if(!is_null($companyInstitution)) {
                if($companyInstitution->deleted_state == 1) {
                    $companyInstitution->deleted_state = 0;
                    $companyInstitution->save();
                    $request->session()->flash('update', true);
                }
                return redirect()->route('administration.company-institution.index');
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
            echo 'error';
        }
    }
}
