<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/RunRegistration.php
class RunRegistration extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'designation',
        'company',
        'entity',
        'dob',
        'run_category',
        'contact_number',
        'tshirt_size',
        'registration_id',
        'bib_number',
    ];
}
