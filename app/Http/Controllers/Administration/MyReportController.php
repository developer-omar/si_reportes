<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportValidation;
use App\Models\City;
use App\Models\CompanyInstitution;
use App\Models\EquipmentStatus;
use App\Models\Report;
use App\Models\Subsidiary;
use Illuminate\Http\Request;
use App\Traits\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class MyReportController extends Controller {
    use Helpers;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $authenticatedUser = Auth::user();
            if (!$authenticatedUser->hasPermissionTo('report', 'user-administration'))
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
        $searchForm = $request->query();

        //get companies / institutions
        $companiesInstitutions = CompanyInstitution::where('deleted_state', '=', 0)
            ->orderBy('name', 'asc')
            ->get();

        //get subsidiaries
        $subsidiaries = array();
        if(array_key_exists('company_institution', $searchForm))
            if($searchForm['company_institution'] != '')
                $subsidiaries = Subsidiary::with([
                    'city' => function($query) {
                        $query->select('id', 'name');
                    }
                ])  ->where('company_institution_id', '=', $searchForm['company_institution'])
                    ->where('deleted_state', '=', 0)
                    ->get();

        //get equipment status
        $equipmentStates = EquipmentStatus::get();

        $reports = Report::with([
            'subsidiary' => function($query) {
                $query->select('id', 'name', 'company_institution_id', 'city_id');
            },
            'subsidiary.companyInstitution' => function($query) {
                $query->select('id', 'name');
            },
            'subsidiary.city' => function($query) {
                $query->select('id', 'name');
            },
            'equipmentStatus' => function($query) {
                $query->select('id', 'name');
            },
            'userAdministration' => function($query) {
                $query->select('id', 'name', 'last_name');
            }
        ]);

        //search for role administrator
        $userAdministration = Auth::user();
        if(!$userAdministration->hasRole('Administrador'))
            $reports = $reports->where('user_administration_id', '=', $userAdministration->id);

        //for search parameters
        if(count($searchForm) > 0) {
            //sql for name
            if(array_key_exists('name', $searchForm))
                if(trim($searchForm['name']) != '')
                    $reports = $reports->where(
                        'name', 'like', "%" . trim($searchForm['name']) . "%"
                    );

            //sql for created_at
            if(array_key_exists('created_at', $searchForm)) {
                if($searchForm['created_at'] != '') {
                    $arrayCreatedAt = explode('/', trim($searchForm['created_at']));
                    $createdAt = $arrayCreatedAt[2] . '-' . $arrayCreatedAt[1] . '-' . $arrayCreatedAt[0];
                    $reports = $reports->where(
                        'created_at', 'like', "%$createdAt%"
                    );
                }
            }

            //sql for company_institution and subsidiaries
            if(array_key_exists('company_institution', $searchForm)) {
                if($searchForm['company_institution'] != ''){
                    if(array_key_exists('subsidiary', $searchForm)) {
                        if($searchForm['subsidiary'] != '') {
                            $reports = $reports->where(
                                'subsidiary_id', '=', $searchForm['subsidiary']
                            );
                        } else {
                            $subsidiaryIds = $this->getSubsidiaryIds($searchForm['company_institution']);
                            $reports = $reports->whereIn(
                                'subsidiary_id', $subsidiaryIds
                            );
                        }
                    } else {
                        $subsidiaryIds = $this->getSubsidiaryIds($searchForm['company_institution']);
                        $reports = $reports->whereIn(
                            'subsidiary_id', $subsidiaryIds
                        );
                    }
                }
            }

            //sql for equipment_status
            if(array_key_exists('equipment_status', $searchForm))
                if($searchForm['equipment_status'] != '') {
                    $reports = $reports->where(
                        'equipment_status_id', '=', $searchForm['equipment_status']
                    );
                }
        }
        /*------------------------------------------------------------------*/

        $reports = $reports->orderBy('created_at', 'desc')
            ->paginate(20);
        //return response()->json($reports);
        return view('administration.my-report.index', [
            'reports' => $reports,
            'companiesInstitutions' => $companiesInstitutions,
            'subsidiaries' => $subsidiaries,
            'equipmentStates' => $equipmentStates,
            'searchForm' => $searchForm
        ]);
    }

    private function getSubsidiaryIds($companyInstitutionId) {
        $subsidiaryIds = Subsidiary::where('company_institution_id', '=', $companyInstitutionId)
            ->where('deleted_state', '=', 0)
            ->pluck('id')
            ->toArray();
        return $subsidiaryIds;
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
        $equipmentStates = EquipmentStatus::get();
        $data = [
            'cardWidth' => 6,
            'title' => 'Adicionar Informe',
            'companiesInstitutions' => $companiesInstitutions,
            'equipmentStates' => $equipmentStates,
            'button' => 'Registrar',
            'action' => route('administration.my-report.store')
        ];
        return view('administration.my-report.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportValidation $request) {
        try {
            $report = new Report();
            $report->name = $request->input('name');
            //$report->company_institution_id = $request->input('company_institution_id');
            $report->subsidiary_id = $request->input('subsidiary_id');
            $report->equipment_status_id = $request->input('equipment_status_id');
            $userAdministration = Auth::user();
            $report->user_administration_id = $userAdministration->id;

            $file = $request->file('file');
            $fileName = $this->getRandomName() . '.' . $file->extension();
            $baseUrl = URL::to('/');
            $report->file = $baseUrl . '/storage/reports/' . $fileName;
            $report->save();
            //save file in disk
            $file->storeAs(
                'reports',
                $fileName,
                'public'
            );
            $request->session()->flash('store', true);
            return redirect()->route('administration.my-report.index');
        }catch (\Exception $e) {
            dd($e);
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
            $report = Report::with([
                'subsidiary' => function($query) {
                    $query->select('id', 'name', 'company_institution_id', 'city_id');
                },
                'subsidiary.companyInstitution' => function($query) {
                    $query->select('id', 'name');
                },
                'subsidiary.city' => function($query) {
                    $query->select('id', 'name');
                },
                'equipmentStatus' => function($query) {
                    $query->select('id', 'name');
                },
                'userAdministration' => function($query) {
                    $query->select('id', 'name', 'last_name');
                }
            ])  ->where('id', '=', $id)
                ->first();
            if(!is_null($report)) {
                $companiesInstitutions = CompanyInstitution::get();
                $subsidiaries = Subsidiary::where('company_institution_id', '=', $report->subsidiary->companyInstitution->id)
                    ->get();
                $equipmentStates = EquipmentStatus::get();
                $data = [
                    'cardWidth' => 6,
                    'title' => 'Editar Informe',
                    'action' => route('administration.my-report.update', ['id' => $id]),
                    'method' => 'PUT',
                    'companiesInstitutions' => $companiesInstitutions,
                    'subsidiaries' => $subsidiaries,
                    'equipmentStates' => $equipmentStates,
                    'report' => $report,
                    'button' => 'Actualizar',
                ];
                return view('administration.my-report.form', $data);
            }else {
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.dashboard'
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            echo "error";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportValidation $request, $id) {
        try {
            $report = Report::find($id);
            if(!is_null($report)) {
                $file = $request->file('file');
                if(!is_null($file)) {
                    //get photo name for delete
                    $arrayFileDb = explode('/', $report->file);
                    $fileDb = $arrayFileDb[count($arrayFileDb) -1];
                    //update photo name
                    $fileName = $this->getRandomName('pdf') . '.' . $file->extension();
                    $baseUrl = URL::to('/');
                    $report->file = $baseUrl . '/storage/reports/' . $fileName;
                }
                $report->name = $request->input('name');
                $report->subsidiary_id = $request->input('subsidiary_id');
                $report->equipment_status_id = $request->input('equipment_status_id');
                $report->save();
                //save file in storage
                if(!is_null($file)) {
                    //save new photo
                    $file->storeAs(
                        'reports',
                        $fileName,
                        'public'
                    );
                    //delete file
                    Storage::disk('public')->delete('reports/' . $fileDb);
                }
                $request->session()->flash('update', true);
                return redirect()->route('administration.my-report.index');
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
            echo 'Error';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        $report = Report::find($id);
        if(!is_null($report)) {
            //delete file
            $arrayFileDb = explode('/', $report->file);
            $fileDb = $arrayFileDb[count($arrayFileDb) -1];
            Storage::disk('public')->delete('reports/' . $fileDb);
            $report->delete();
            $request->session()->flash('destroy', true);
            return redirect()->route('administration.my-report.index');
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
}
