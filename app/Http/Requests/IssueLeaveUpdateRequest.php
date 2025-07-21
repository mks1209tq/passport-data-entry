<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IssueLeaveUpdateRequest extends FormRequest
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
            'is_leave' => 'boolean',
            'is_visa' => 'boolean',
            'is_photo' => 'boolean',
            'is_no_file_uploaded' => 'boolean',
            'is_issue' => 'boolean',
        ];
    }
} 