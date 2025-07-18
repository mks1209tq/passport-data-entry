<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the user assigned to this leave request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the first verifier assigned to this leave request.
     */
    public function verifier1User()
    {
        return $this->belongsTo(User::class, 'verifier1');
    }

    /**
     * Get the second verifier assigned to this leave request.
     */
    public function verifier2User()
    {
        return $this->belongsTo(User::class, 'verifier2');
    }

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
        'user_id',
        'is_data_entered',
        'verify_count',
        'verifier1',
        'verifier2',
        'verifier1_id',
        'verifier2_id',
        're_entry',
        'is_data_correct',
        'is_issue',
        'is_leave',
        'is_visa',
        'is_photo',
        'is_no_file_uploaded',
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
        'is_data_entered' => 'boolean',
        'verify_count' => 'integer',
        're_entry' => 'boolean',
        'is_data_correct' => 'boolean',
        'is_issue' => 'boolean',
        'is_leave' => 'boolean',
        'is_visa' => 'boolean',
        'is_photo' => 'boolean',
        'is_no_file_uploaded' => 'boolean',
    ];
}
