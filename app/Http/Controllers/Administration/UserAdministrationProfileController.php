<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileValidation;
use App\Models\UserAdministration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAdministrationProfileController extends Controller {
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        $authenticatedUser = Auth::user();
        $user = UserAdministration::find($authenticatedUser->id);
        $data = [
            'user' => $user
        ];
        return view('administration.user-administration-profile.show', $data);
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
            'action' => route('administration.user-profile.update'),
            'method' => 'PUT',
            'cardWidth' => 6,
            'user' => $user
        ];
        return view('administration.user-administration-profile.form', $data);
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
            $userAdministration = UserAdministration::find($authenticatedUser->id);
            $userAdministration->name = $request->input('name');
            $userAdministration->last_name = $request->input('last_name');
            $userAdministration->email = $request->input('email');
            $userAdministration->save();
            return redirect()->route('administration.user-profile.show');
        } catch (\Exception $e) {
            return redirect()->route('administration.user-profile.show');
        }
    }
}
