<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = RouteServiceProvider::INDEX;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('guest')->except(['userCompanyInstitutionLogout', 'userAdministrationLogout']);
        $this->middleware('guest:user-company-institution')->except(['userCompanyInstitutionLogout', 'userAdministrationLogout']);
        $this->middleware('guest:user-administration')->except(['userCompanyInstitutionLogout', 'userAdministrationLogout']);
    }

    /* Login form for users company / institution */

    public function showUserCompanyInstitutionLoginForm() {
        return view('auth.login', ['typeLogin' => 'empresas-instituciones']);
    }

    public function userCompanyInstitutionLogin(Request $request) {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (
            Auth::guard('user-company-institution')->attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ], $request->get('remember')
            )
        ) {
            //return redirect()->intended();
            return redirect()->route('page.report.index');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function userCompanyInstitutionLogout(Request $request) {
        Auth::logout();
        return redirect()->route('page.company-institution.index');
    }

    /* Login form for users inbustrade */

    public function showUserAdministrationLoginForm() {
        return view('auth.login', ['typeLogin' => 'administracion']);
    }

    public function userAdministrationLogin(Request $request) {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (
            Auth::guard('user-administration')->attempt(
                $this->credentials($request),
                $request->filled('remember')
            )
        ) {
            //return redirect()->intended();
            return redirect()->route('administration.index.index');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

    public function userAdministrationLogout(Request $request) {
        Auth::logout();
        return redirect()->route('auth.login.show-user-administration-login-form');
    }


    public function credentials(Request $request) {
        return array_merge(
            $request->only($this->username(), 'password'),
            ['deleted_state' => 0]
        );
    }

}
