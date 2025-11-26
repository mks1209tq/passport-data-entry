<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TIPLUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tiplId = $this->route('tipl')->id ?? null;
        
        return [
            'name' => ['required', 'string', 'max:100'],
            'employee_id' => [
                'required',
                'string',
                'max:100',
                'unique:tipl,employee_id,' . $tiplId . ',id,deleted_at,NULL'
            ],
            'company_name' => ['required', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'max:20'],
            'pick_up_point' => ['required', 'string', 'max:100', 'in:Self,Al Quoz,International City,ADCB,Head Office'],
            'in_house_talent' => ['nullable', 'string', 'in:yes,no'],
            'expected_guests' => ['required', 'integer', 'min:0', 'max:3'],
        ];
    }
}
