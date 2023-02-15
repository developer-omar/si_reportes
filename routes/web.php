<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'login' => false,
    'logout' => false,
    'register' => false,
    'reset' => false
]);

//ROOT
Route::get(
    '/',
    [App\Http\Controllers\Page\CompanyInstitutionController::class, 'index']
)   ->name('page.company-institution.index');

//routes for login of company / institution users
Route::get(
    '/empresas-instituciones',
    [App\Http\Controllers\Auth\LoginController::class, 'showUserCompanyInstitutionLoginForm']
)   ->name('auth.login.show-user-company-institution-login-form');

Route::post(
    '/empresas-instituciones',
    [App\Http\Controllers\Auth\LoginController::class, 'userCompanyInstitutionLogin']
)   ->name('auth.login.user-company-institution-login');

//routes for login of inb users
Route::get(
    '/administracion',
    [App\Http\Controllers\Auth\LoginController::class, 'showUserAdministrationLoginForm']
)   ->name('auth.login.show-user-administration-login-form');

Route::post(
    '/administracion',
    [App\Http\Controllers\Auth\LoginController::class, 'userAdministrationLogin']
)   ->name('auth.login.user-administration-login');

//routes for company / institution users
Route::middleware(['auth:user-company-institution'])->group(function () {
    Route::prefix('empresas-instituciones')->group(function () {
        //REPORTS
        Route::get(
            '/informes',
            [App\Http\Controllers\Page\ReportController::class, 'index']
        )   ->name('page.report.index');

        //USER PROFILE
        Route::get(
            '/perfil-usuario',
            [App\Http\Controllers\Page\UserCompanyInstitutionProfileController::class, 'show']
        )   ->name('page.user-company-institution-profile.show');

        Route::get(
            '/perfil-usuario/editar',
            [App\Http\Controllers\Page\UserCompanyInstitutionProfileController::class, 'edit']
        )   ->name('page.user-company-institution-profile.edit');

        Route::put(
            '/perfil-usuario/actualizar',
            [App\Http\Controllers\Page\UserCompanyInstitutionProfileController::class, 'update']
        )   ->name('page.user-company-institution-profile.update');

        //CHANGE PASSWORD
        Route::get(
            '/cambiar-contrasena/editar',
            [App\Http\Controllers\Page\ChangePasswordController::class, 'edit']
        )   ->name('page.change-password.edit');

        Route::put(
            '/cambiar-contrasena/actualizar',
            [App\Http\Controllers\Page\ChangePasswordController::class, 'update']
        )   ->name('page.change-password.update');

        //LOGOUT
        Route::get(
            '/cerrar-sesion',
            [App\Http\Controllers\Auth\LoginController::class, 'userCompanyInstitutionLogout']
        )   ->name('auth.login.user-company-institution-logout');
    });
});

//Routes protected for users inb
Route::middleware(['auth:user-administration'])->group(function () {
    Route::prefix('administracion')->group(function () {
        //INDEX COMPANIES
        Route::get(
            '/inicio',
            [App\Http\Controllers\Administration\IndexController::class, 'index']
        )   ->name('administration.index.index');

        Route::get(
            '/{idCompanyInstitution}/{nameCompanyInstitution}',
            [App\Http\Controllers\Administration\CompanyInstitutionReportController::class, 'index']
        )   ->where('idCompanyInstitution', '[0-9]+')
            ->name('administration.company-institution-report.index');

        //USER PROFILE
        Route::get(
            '/perfil-usuario',
            [App\Http\Controllers\Administration\UserAdministrationProfileController::class, 'show']
        )   ->name('administration.user-profile.show');

        Route::get(
            '/perfil-usuario/editar',
            [App\Http\Controllers\Administration\UserAdministrationProfileController::class, 'edit']
        )   ->name('administration.user-profile.edit');

        Route::put(
            '/perfil-usuario/actualizar',
            [App\Http\Controllers\Administration\UserAdministrationProfileController::class, 'update']
        )   ->name('administration.user-profile.update');

        //COMPANIES INSTITUTIONS
        Route::get(
            '/empresas-instituciones',
            [App\Http\Controllers\Administration\CompanyInstitutionController::class, 'index']
        )   ->name('administration.company-institution.index');

        Route::get(
            '/empresas-instituciones/adicionar',
            [App\Http\Controllers\Administration\CompanyInstitutionController::class, 'create']
        )   ->name('administration.company-institution.create');

        Route::post(
            '/empresas-instituciones/registrar',
            [App\Http\Controllers\Administration\CompanyInstitutionController::class, 'store']
        )   ->name('administration.company-institution.store');

        Route::get(
            '/empresas-instituciones/editar/{id}',
            [App\Http\Controllers\Administration\CompanyInstitutionController::class, 'edit']
        )   ->name('administration.company-institution.edit')
            ->where('id', '[0-9]+');

        Route::put(
            '/empresas-instituciones/actualizar/{id}',
            [App\Http\Controllers\Administration\CompanyInstitutionController::class, 'update']
        )   ->name('administration.company-institution.update')
            ->where('id', '[0-9]+');

        Route::delete(
            '/empresas-instituciones/eliminar/{id}',
            [App\Http\Controllers\Administration\CompanyInstitutionController::class, 'destroy']
        )   ->name('administration.company-institution.destroy')
            ->where('id', '[0-9]+');

        Route::put(
            '/empresas-instituciones/restituir/{id}',
            [App\Http\Controllers\Administration\CompanyInstitutionController::class, 'restore']
        )   ->name('administration.company-institution.restore')
            ->where('id', '[0-9]+');

        //SUBSIDIARIES OF INSTITUTIONS
        Route::get(
            '/sucursales',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'index']
        )   ->name('administration.subsidiary.index');

        Route::get(
            '/sucursales/adicionar',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'create']
        )   ->name('administration.subsidiary.create');

        Route::post(
            '/sucursales/registrar',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'store']
        )   ->name('administration.subsidiary.store');

        Route::get(
            '/sucursales/editar/{id}',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'edit']
        )   ->name('administration.subsidiary.edit')
            ->where('id', '[0-9]+');

        Route::put(
            '/sucursales/actualizar/{id}',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'update']
        )   ->name('administration.subsidiary.update')
            ->where('id', '[0-9]+');

        Route::delete(
            '/sucursales/eliminar/{id}',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'destroy']
        )   ->name('administration.subsidiary.destroy')
            ->where('id', '[0-9]+');

        Route::put(
            '/sucursales/restituir/{id}',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'restore']
        )   ->name('administration.subsidiary.restore')
            ->where('id', '[0-9]+');

        Route::get(
            '/empresas-instituciones/{id}/sucursales',
            [App\Http\Controllers\Administration\SubsidiaryController::class, 'show']
        )   ->name('administration.subsidiary.show')
            ->where('id', '[0-9]+');

        //REPORTS
        Route::get(
            '/mis-informes',
            [App\Http\Controllers\Administration\MyReportController::class, 'index']
        )   ->name('administration.my-report.index');

        Route::get(
            '/mis-informes/adicionar',
            [App\Http\Controllers\Administration\MyReportController::class, 'create']
        )   ->name('administration.my-report.create');

        Route::post(
            '/mis-informes/registrar',
            [App\Http\Controllers\Administration\MyReportController::class, 'store']
        )   ->name('administration.my-report.store');

        Route::get(
            '/mis-informes/editar/{id}',
            [App\Http\Controllers\Administration\MyReportController::class, 'edit']
        )   ->name('administration.my-report.edit')
            ->where('id', '[0-9]+');

        Route::put(
            '/mis-informes/actualizar/{id}',
            [App\Http\Controllers\Administration\MyReportController::class, 'update']
        )   ->name('administration.my-report.update')
            ->where('id', '[0-9]+');

        Route::delete(
            '/mis-informes/eliminar/{id}',
            [App\Http\Controllers\Administration\MyReportController::class, 'destroy']
        )   ->name('administration.my-report.destroy')
            ->where('id', '[0-9]+');

        //USERS
        Route::get(
            '/usuarios',
            [App\Http\Controllers\Administration\UserAdministrationController::class, 'index']
        )   ->name('administration.user-administration.index');

        Route::get(
            '/usuarios/adicionar',
            [App\Http\Controllers\Administration\UserAdministrationController::class, 'create']
        )   ->name('administration.user-administration.create');

        Route::post(
            '/usuarios/registrar',
            [App\Http\Controllers\Administration\UserAdministrationController::class, 'store']
        )   ->name('administration.user-administration.store');

        Route::get(
            '/usuarios/editar/{id}',
            [App\Http\Controllers\Administration\UserAdministrationController::class, 'edit']
        )   ->name('administration.user-administration.edit')
            ->where('id', '[0-9]+');

        Route::put(
            '/usuarios/actualizar/{id}',
            [App\Http\Controllers\Administration\UserAdministrationController::class, 'update']
        )   ->name('administration.user-administration.update')
            ->where('id', '[0-9]+');

        Route::delete(
            '/usuarios/eliminar/{id}',
            [App\Http\Controllers\Administration\UserAdministrationController::class, 'destroy']
        )   ->name('administration.user-administration.destroy')
            ->where('id', '[0-9]+');

        Route::put(
            '/usuarios/restituir/{id}',
            [App\Http\Controllers\Administration\UserAdministrationController::class, 'restore']
        )   ->name('administration.user-administration.restore')
            ->where('id', '[0-9]+');

        //CHANGE PASSWORD
        Route::get(
            '/cambiar-contrasena/editar',
            [App\Http\Controllers\Administration\ChangePasswordController::class, 'edit']
        )   ->name('administration.change-password.edit');

        Route::put(
            '/cambiar-contrasena/actualizar',
            [App\Http\Controllers\Administration\ChangePasswordController::class, 'update']
        )   ->name('administration.change-password.update');

        //USER COMPANY INSTITUTION
        Route::get(
            '/usuarios-empresas-instituciones',
            [App\Http\Controllers\Administration\UserCompanyInstitutionController::class, 'index']
        )   ->name('administration.user-company-institution.index');

        Route::get(
            '/usuarios-empresas-instituciones/adicionar',
            [App\Http\Controllers\Administration\UserCompanyInstitutionController::class, 'create']
        )   ->name('administration.user-company-institution.create');

        Route::post(
            '/uusuarios-empresas-instituciones/registrar',
            [App\Http\Controllers\Administration\UserCompanyInstitutionController::class, 'store']
        )   ->name('administration.user-company-institution.store');

        Route::get(
            '/usuarios-empresas-instituciones/editar/{id}',
            [App\Http\Controllers\Administration\UserCompanyInstitutionController::class, 'edit']
        )   ->name('administration.user-company-institution.edit')
            ->where('id', '[0-9]+');

        Route::put(
            '/usuarios-empresas-instituciones/actualizar/{id}',
            [App\Http\Controllers\Administration\UserCompanyInstitutionController::class, 'update']
        )   ->name('administration.user-company-institution.update')
            ->where('id', '[0-9]+');

        Route::delete(
            '/usuarios-empresas-instituciones/eliminar/{id}',
            [App\Http\Controllers\Administration\UserCompanyInstitutionController::class, 'destroy']
        )   ->name('administration.user-company-institution.destroy')
            ->where('id', '[0-9]+');

        //LOGOUT
        Route::get(
            '/cerrar-sesion',
            [App\Http\Controllers\Auth\LoginController::class, 'userAdministrationLogout']
        )   ->name('auth.login.user-administration-logout');
    });
});
