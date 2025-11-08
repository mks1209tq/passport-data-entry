<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'designation' => ['nullable', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'proposalBy' => ['nullable', 'string', 'max:100'],
            'guestOf' => ['nullable', 'string', 'max:100'],
            'RSVP' => ['nullable', 'string', 'max:100'],
            'tableAllocation' => ['nullable', 'string', 'max:100'],
            'attendance' => ['nullable', 'string', 'max:100'],
        ];
    }
}
