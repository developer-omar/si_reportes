<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAdministrationValidation extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $id = $this->route('id');
        if($this->method() === 'POST') {
            $passwordRules = [
                'required',
                'min:8'
            ];
        } else {
            if($this->input('swEnablePassword') == "1")
                $passwordRules = [
                    'required',
                    'min:8'
                ];
            else
                $passwordRules = [];
        }
        return [
            'name' => ['required'],
            'last_name' => ['required'],
            'email' => [
                'required',
                'email',
                Rule::unique("users", "email")->ignore($id)
            ],
            'password' => $passwordRules
        ];
    }
}
