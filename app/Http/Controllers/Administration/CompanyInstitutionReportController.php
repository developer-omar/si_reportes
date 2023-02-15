<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\CompanyInstitution;
use App\Models\EquipmentStatus;
use App\Models\Report;
use App\Models\Subsidiary;
use App\Traits\Helpers;
use Illuminate\Http\Request;

class CompanyInstitutionReportController extends Controller {
    use Helpers;

    public function index( Request $request, $idCompanyInstitution, $nameCompanyInstitution) {
        try {
            $companyInstitution = CompanyInstitution::find($idCompanyInstitution);
            if(is_null($companyInstitution)){
                return response()->view(
                    'common.errors.404',
                    [
                        'layout' => 'administration.layout.dashboard'
                    ],
                    404
                );
            }

            //get url parameters
            $searchForm = $request->query();

            //get subsidiaries
            $subsidiaries = Subsidiary::with([
                'city' => function($query) {
                    $query->select('id', 'name');
                }
            ])  ->where('company_institution_id', '=', $idCompanyInstitution)
                ->where('deleted_state', '=', 0)
                ->orderBy('name', 'asc')
                ->get();

            //get equipment status
            $equipmentStates = EquipmentStatus::get();

            //make sql for reports
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

            //for search parameters
            $isSubsidiary = false;
            if(count($searchForm) > 0) {
                //sql for name
                if(array_key_exists('name', $searchForm)) {
                    if (trim($searchForm['name']) != '') {
                        $reports = $reports->where(
                            'name', 'like',
                            "%" . trim($searchForm['name']) . "%"
                        );
                    }
                }

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

                //sql for subsidiary / subsidiaries
                if(array_key_exists('subsidiary', $searchForm)) {
                    if($searchForm['subsidiary'] != '') {
                        $reports = $reports->where(
                            'subsidiary_id', '=',
                            $searchForm['subsidiary']
                        );
                        $isSubsidiary = true;
                    }
                }

                //sql for equipment_status
                if(array_key_exists('equipment_status', $searchForm)) {
                    if ($searchForm['equipment_status'] != '') {
                        $reports = $reports->where(
                            'equipment_status_id', '=',
                            $searchForm['equipment_status']
                        );
                    }
                }
            }

            // if not subsidiary parameter search
            if($isSubsidiary == false) {
                //get ids for subsidiaries
                $subsidiaryIds = [];
                foreach ($subsidiaries as $subsidiary) {
                    $subsidiaryIds[] = $subsidiary->id;
                }
                $reports = $reports->whereIn(
                    'subsidiary_id', $subsidiaryIds
                );
            }

            $reports = $reports->orderBy('created_at', 'desc')
                ->paginate(20);
            return view('administration.company-institution-report.index', [
                'nameCompanyInstitutionDb' => $companyInstitution->name,
                'subsidiaries' => $subsidiaries,
                'equipmentStates' => $equipmentStates,
                'idCompanyInstitution' => $idCompanyInstitution,
                'nameCompanyInstitution' => $nameCompanyInstitution,
                'reports' => $reports,
                'searchForm' => $searchForm
            ]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
