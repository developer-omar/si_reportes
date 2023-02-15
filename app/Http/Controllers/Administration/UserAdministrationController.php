<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAdministrationValidation;
use App\Models\CompanyInstitution;
use App\Models\Report;
use App\Models\User;
use App\Models\UserAdministration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserAdministrationController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $authenticatedUser = Auth::user();
            if (!$authenticatedUser->hasPermissionTo('user_administration', 'user-administration'))
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
    public function index() {
        $usersAdministration = UserAdministration::paginate(20);;
        $data = [
            'users' => $usersAdministration
        ];
        return view('administration.user-administration.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $data = [
            'cardWidth' => 6,
            'title' => 'Adicionar Usuario',
            'button' => 'Registrar',
            'action' => route('administration.user-administration.store'),
            'hasRoleUser' => true,
            'hasRoleAdministrator' => false,
            'reportPermissions' => true,
            'companyInstitutionPermissions' => false,
            'subsidiaryPermissions' => false,
            'userCompanyInstitutionPermissions' => false,
        ];
        return view('administration.user-administration.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAdministrationValidation $request) {
        try {
            $userAdministration = new UserAdministration();
            $userAdministration->name = $request->input('name');
            $userAdministration->last_name = $request->input('last_name');
            $userAdministration->email = $request->input('email');
            $userAdministration->password = Hash::make($request->input('password'));
            $userAdministration->save();
            $role = $request->input('role');
            if($role == 'user') {
                $userAdministration->assignRole('Usuario');
                //assign permissions to created role
                if($request->input('reportPermissions') == 1)
                    $userAdministration->givePermissionTo('report');
                if($request->input('companyInstitutionPermissions') == 1)
                    $userAdministration->givePermissionTo('company_institution');
                if($request->input('subsidiaryPermissions') == 1)
                    $userAdministration->givePermissionTo('subsidiary');
                if($request->input('userCompanyInstitutionPermissions') == 1)
                    $userAdministration->givePermissionTo('user_company_institution');
            } elseif($role == 'administrator') {
                $userAdministration->assignRole('Administrador');
                $userAdministration->givePermissionTo('report');
                $userAdministration->givePermissionTo('company_institution');
                $userAdministration->givePermissionTo('subsidiary');
                $userAdministration->givePermissionTo('user_company_institution');
            }
            $request->session()->flash('store', true);
            return redirect()->route('administration.user-administration.index');
        } catch (\Exception $e) {
            return redirect()->route('administration.user-administration.index');
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
            $userAdministration = UserAdministration::find($id);
            if(!is_null($userAdministration)) {
                $hasRoleUser = $userAdministration->hasRole('Usuario');
                $hasRoleAdministrator = $userAdministration->hasRole('Administrador');
                if($hasRoleUser) {
                    $reportPermissions = $userAdministration->hasPermissionTo('report', 'user-administration');
                    $companyInstitutionPermissions = $userAdministration->hasPermissionTo('company_institution', 'user-administration');
                    $subsidiaryPermissions = $userAdministration->hasPermissionTo('subsidiary', 'user-administration');
                    $userCompanyInstitutionPermissions = $userAdministration->hasPermissionTo('user_company_institution', 'user-administration');
                } else {
                    $reportPermissions = true;
                    $companyInstitutionPermissions = true;
                    $subsidiaryPermissions = true;
                }
                $data = [
                    'cardWidth' => 6,
                    'title' => 'Editar Usuario',
                    'action' => route('administration.user-administration.update', ['id' => $id]),
                    'method' => 'PUT',
                    'user' => $userAdministration,
                    'hasRoleUser' => $hasRoleUser,
                    'hasRoleAdministrator' => $hasRoleAdministrator,
                    'reportPermissions' => $reportPermissions,
                    'companyInstitutionPermissions' => $companyInstitutionPermissions,
                    'subsidiaryPermissions' => $subsidiaryPermissions,
                    'userCompanyInstitutionPermissions' => $userCompanyInstitutionPermissions,
                    'button' => 'Actualizar',
                ];
                return view('administration.user-administration.form', $data);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserAdministrationValidation $request, $id) {
        try {
            $userAdministration = UserAdministration::find($id);
            if(!is_null($userAdministration)) {
                //user data
                $userAdministration->name = $request->input('name');
                $userAdministration->last_name = $request->input('last_name');
                $userAdministration->email = $request->input('email');
                $password = $request->input('password');
                if(!is_null($password))
                    $userAdministration->password = Hash::make(trim($password));
                $userAdministration->save();
                //remove role and permissions
                $hasRoleUser = $userAdministration->hasRole('Usuario');
                if($hasRoleUser) {
                    $userAdministration->removeRole('Usuario');
                    if($userAdministration->hasPermissionTo('company_institution', 'user-administration'))
                        $userAdministration->revokePermissionTo('company_institution');
                    if($userAdministration->hasPermissionTo('subsidiary', 'user-administration'))
                        $userAdministration->revokePermissionTo('subsidiary');
                    if($userAdministration->hasPermissionTo('report', 'user-administration'))
                        $userAdministration->revokePermissionTo('report');
                    if($userAdministration->hasPermissionTo('user_company_institution', 'user-administration'))
                        $userAdministration->revokePermissionTo('user_company_institution');
                } else {
                    $userAdministration->removeRole('Administrador');
                    $userAdministration->revokePermissionTo('company_institution');
                    $userAdministration->revokePermissionTo('subsidiary');
                    $userAdministration->revokePermissionTo('report');
                    $userAdministration->revokePermissionTo('user_administration');
                    $userAdministration->revokePermissionTo('user_company_institution');
                }
                //add new role and permissions
                $role = $request->input('role');
                if($role == 'user') {
                    //assign role to user
                    $userAdministration->assignRole('Usuario');
                    //assign permissions to created role
                    if($request->input('companyInstitutionPermissions') == 1)
                        $userAdministration->givePermissionTo('company_institution');
                    if($request->input('subsidiaryPermissions') == 1)
                        $userAdministration->givePermissionTo('subsidiary');
                    if($request->input('reportPermissions') == 1)
                        $userAdministration->givePermissionTo('report');
                    if($request->input('userCompanyInstitutionPermissions') == 1)
                        $userAdministration->givePermissionTo('user_company_institution');
                } else {
                    //assign role administrator to user
                    $userAdministration->assignRole('Administrador');
                    $userAdministration->givePermissionTo('report');
                    $userAdministration->givePermissionTo('company_institution');
                    $userAdministration->givePermissionTo('subsidiary');
                    $userAdministration->givePermissionTo('user_administration');
                    $userAdministration->givePermissionTo('user_company_institution');
                }
                $request->session()->flash('update', true);
                return redirect()->route('administration.user-administration.index');
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
    public function destroy(Request $request, $id) {
        try {
            $userAdministration = UserAdministration::find($id);
            if(!is_null($userAdministration)) {
                $reports = Report::where('user_administration_id', '=', $id)
                    ->get();
                if($reports->count() > 0) {
                    $userAdministration->deleted_state = 1;
                    $userAdministration->save();
                } else {
                    //delete permissions and role
                    //delete permissions in role_has_permissions
                    if($userAdministration->hasPermissionTo('company_institution', 'user-administration'))
                        $userAdministration->revokePermissionTo('company_institution');
                    if($userAdministration->hasPermissionTo('subsidiary', 'user-administration'))
                        $userAdministration->revokePermissionTo('subsidiary');
                    if($userAdministration->hasPermissionTo('report', 'user-administration'))
                        $userAdministration->revokePermissionTo('report');
                    if($userAdministration->hasPermissionTo('user_administration', 'user-administration'))
                        $userAdministration->revokePermissionTo('user_administration');
                    if($userAdministration->hasPermissionTo('user_company_institution', 'user-administration'))
                        $userAdministration->revokePermissionTo('user_company_institution');
                    if($userAdministration->hasRole('Usuario'))
                        $userAdministration->removeRole('Usuario');
                    else
                        $userAdministration->removeRole('Administrador');
                    //delete user
                    $userAdministration->delete();
                }
                $request->session()->flash('destroy', true);
                return redirect()->route('administration.user-administration.index');
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

    /*private function deleteRoleAndPermissions($user) {
        try {
            $userRole = Role::findByName('Usuario-' . $user->id);
        } catch (\Exception $e) {
            $userRole = null;
        }
        if(!is_null($userRole)) {
            //delete permissions in role_has_permissions
            if($userRole->hasPermissionTo('report'))
                $userRole->revokePermissionTo('report');
            if($userRole->hasPermissionTo('company_institution'))
                $userRole->revokePermissionTo('company_institution');
            if($userRole->hasPermissionTo('subsidiary'))
                $userRole->revokePermissionTo('subsidiary');
            //delete role in model_has_roles
            DB::table('model_has_roles')->where('model_id', '=', $user->id)->delete();
            //delete role in roles
            DB::table('roles')->where('name', '=', 'Usuario-' . $user->id)->delete();
        }
    }*/

    /**
     * Restore the user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $id) {
        try {
            $userAdministration = UserAdministration::find($id);
            if(!is_null($userAdministration)) {
                if($userAdministration->deleted_state == 1){
                    $userAdministration->deleted_state = 0;
                    $userAdministration->save();
                    $request->session()->flash('update', true);
                }
                return redirect()->route('administration.user-administration.index');
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
            echo "error";
        }
    }

}
