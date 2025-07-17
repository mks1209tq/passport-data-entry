<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'formId',
        'submissionDate',
        'employeeId',
        'leaveType',
        'isEmergency',
        'lastRejoinDate',
        'residence',
        'leaveStartDate',
        'leaveEndDate',
        'duration',
        'travelDestination',
        'reason',
        'destinationAddress',
        'destinationPhone',
        'contactNumberUAE',
        'employeeEmail',
        'approvedByEngineer',
        'approvedByProjectManager',
        'approvedBySrPM',
        'approvedByHOD',
        'eligibleDays',
        'passportEndDate',
        'visaEndDate',
        'workPermitEndDate',
        'ticketEligibility',
        'leaveSalaryEligibility',
        'eligibiltyCheckedBy',
        'approvedByHRManager',
        'approvedByCEO',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'submissionDate' => 'datetime',
        'isEmergency' => 'boolean',
        'lastRejoinDate' => 'datetime',
        'leaveStartDate' => 'datetime',
        'leaveEndDate' => 'datetime',
        'approvedByEngineer' => 'boolean',
        'approvedByProjectManager' => 'boolean',
        'approvedBySrPM' => 'boolean',
        'approvedByHOD' => 'boolean',
        'passportEndDate' => 'datetime',
        'visaEndDate' => 'datetime',
        'workPermitEndDate' => 'datetime',
        'ticketEligibility' => 'boolean',
        'leaveSalaryEligibility' => 'boolean',
        'approvedByHRManager' => 'boolean',
        'approvedByCEO' => 'boolean',
    ];
}
