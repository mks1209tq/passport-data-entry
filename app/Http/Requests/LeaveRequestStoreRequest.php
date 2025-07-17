<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequestStoreRequest extends FormRequest
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
            'formId' => ['nullable', 'string', 'max:100'],
            'submissionDate' => ['nullable'],
            'employeeId' => ['nullable', 'string', 'max:100'],
            'leaveType' => ['nullable', 'in:Annual,Medical,Other'],
            'isEmergency' => ['nullable'],
            'lastRejoinDate' => ['nullable'],
            'residence' => ['nullable', 'string', 'max:100'],
            'leaveStartDate' => ['nullable'],
            'leaveEndDate' => ['nullable'],
            'duration' => ['nullable', 'string'],
            'travelDestination' => ['nullable', 'string', 'max:100'],
            'reason' => ['nullable', 'string'],
            'destinationAddress' => ['nullable', 'string', 'max:100'],
            'destinationPhone' => ['nullable', 'string', 'max:100'],
            'contactNumberUAE' => ['nullable', 'string', 'max:100'],
            'employeeEmail' => ['nullable', 'string', 'max:100'],
            'approvedByEngineer' => ['nullable'],
            'approvedByProjectManager' => ['nullable'],
            'approvedBySrPM' => ['nullable'],
            'approvedByHOD' => ['nullable'],
            'eligibleDays' => ['nullable', 'string'],
            'passportEndDate' => ['nullable'],
            'visaEndDate' => ['nullable'],
            'workPermitEndDate' => ['nullable'],
            'ticketEligibility' => ['nullable'],
            'leaveSalaryEligibility' => ['nullable'],
            'eligibiltyCheckedBy' => ['nullable', 'string', 'max:100'],
            'approvedByHRManager' => ['nullable'],
            'approvedByCEO' => ['nullable'],
            'status' => ['nullable', 'string', 'max:100'],
        ];
    }
}
