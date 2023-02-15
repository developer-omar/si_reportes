<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request) {
        if (! $request->expectsJson()) {
            //return route('login');
//            if ($request->is('administracion/*')) {
//                return route('administration.login-form');
//            }
//            if ($request->is('empresas-instituciones/*')) {
//                return route('company-institution.login-form');
//            }
        }
    }
}
