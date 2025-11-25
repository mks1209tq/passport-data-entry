<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\TqUser;

class TIPLStoreRequest extends FormRequest
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
        return [
            'tq_user_id' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $tqUser = TqUser::where('id_code', $value)->first();
                    if (!$tqUser) {
                        $fail('The provided ID is not valid. Please verify your ID first.');
                    }
                },
            ],
            'name' => ['required', 'string', 'max:100'],
            'employee_id' => [
                'required',
                'string',
                'max:100',
                'unique:tipl,employee_id,NULL,id,deleted_at,NULL'
            ],
            'company_name' => ['required', 'string', 'max:100'],
            'phone_number' => ['required', 'string', 'max:20'],
            'pick_up_point' => ['nullable', 'string', 'max:100'],
            'in_house_talent' => ['nullable', 'string', 'in:yes,no'],
            'expected_guests' => ['required', 'integer', 'min:0', 'max:9999'],
        ];
    }
}
