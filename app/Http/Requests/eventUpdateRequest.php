<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class eventUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'designation' => ['nullable', 'string', 'max:100'],
            'comapanyName' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:100'],
            'proposalBy' => ['nullable', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:100'],
            'RSVP' => ['nullable', 'string', 'max:100'],
            'tableAllocation' => ['nullable', 'string', 'max:100'],
        ];
    }
}
