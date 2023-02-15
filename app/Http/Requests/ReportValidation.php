<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'company_institution_id' => ['required', 'numeric'],
            'subsidiary_id' => ['required', 'numeric'],
            'equipment_status_id' => ['required', 'numeric'],
            'file' => [
                Rule::requiredIf($this->method() === 'POST'),
                'mimes:pdf',
                'max:5120'
            ]
        ];
    }
}
