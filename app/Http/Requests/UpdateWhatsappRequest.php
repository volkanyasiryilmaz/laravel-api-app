<?php

namespace App\Http\Requests;

use Anik\Form\FormRequest;

class UpdateWhatsappRequest extends FormRequest
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
            /*'Data' => 'string|required',*/
            'WhatsappAyar1' => 'required|string',
            'WhatsappAyar2' => 'required|string',
            'WhatsappAyar3' => 'required|string',
            'WhatsappAyar4' => 'required|string',
            'WhatsappAyar5' => 'required|string',
            'WhatsappAyar6' => 'required|string',
            'WhatsappAyar7' => 'required|string',
            'WhatsappAyar8' => 'required|string',
            'WhatsappAyar9' => 'required|string',
            'WhatsappAyar10' => 'required|string',
            'WhatsappAyar11' => 'required|string',
            'WhatsappAyar12' => 'required|string',
            'WhatsappAyar13' => 'required|string',
            'WhatsappAyar14' => 'required|string',
            'WhatsappAyar15' => 'required|string',
     
        ];

    }
}