<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileValidation;
use App\Models\UserAdministration;
use App\Models\UserCompanyInstitution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCompanyInstitutionProfileController extends Controller {
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $authenticatedUser = Auth::user();
        $userCompanyInstitution = UserCompanyInstitution::find($authenticatedUser->id);
        $data = [
            'userCompanyInstitution' => $userCompanyInstitution
        ];
        return view('page.user-company-institution-profile.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        $user = Auth::user();
        $data = [
            'title' => 'Editar Perfil de Usuario',
            'action' => route('page.user-company-institution-profile.update'),
            'method' => 'PUT',
            'cardWidth' => 6,
            'user' => $user
        ];
        return view('page.user-company-institution-profile.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserProfileValidation $request) {
        try {
            $authenticatedUser = Auth::user();
            $userCompanyInstitution = UserCompanyInstitution::find($authenticatedUser->id);
            $userCompanyInstitution->name = $request->input('name');
            $userCompanyInstitution->last_name = $request->input('last_name');
            $userCompanyInstitution->email = $request->input('email');
            $userCompanyInstitution->save();
            return redirect()->route('page.user-company-institution-profile.show');
        } catch (\Exception $e) {
            return redirect()->route('page.user-company-institution-profile.show');
        }
    }
}
