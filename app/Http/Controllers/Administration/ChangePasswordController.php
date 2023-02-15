<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordValidation;
use App\Models\User;
use App\Models\UserAdministration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller {
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        try {
            $data = [
                'cardWidth' => 6,
                'title' => 'Cambiar Password',
                'action' => route('administration.change-password.update'),
                'method' => 'PUT',
                'button' => 'Actualizar',
            ];
            return view('administration.change-password.form', $data);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ChangePasswordValidation  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ChangePasswordValidation $request) {
        try {
            $userAdministration = UserAdministration::find(Auth::id());
            $password = $request->input('password');
            if(Hash::check($password, $userAdministration->password)){
                $userAdministration->password = Hash::make($request->input('new_password'));
                $userAdministration->save();
                Auth::logout();
                return redirect()->route('auth.login.show-user-administration-login-form');
            } else {
                $request->session()->flash('error', true);
                return redirect()->route('administration.change-password.edit');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
