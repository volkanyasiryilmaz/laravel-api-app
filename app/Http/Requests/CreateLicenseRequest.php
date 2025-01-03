<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class CreateLicenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'email' => 'required|string|email|unique:licenses',
            'password' => 'required|string',
            'machine_code' => 'required|string|unique:licenses',
            'name' => 'required|string',
            'surname' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'license_type' => 'required|string',
            'status' => 'required|boolean',
        ];
    }
}
