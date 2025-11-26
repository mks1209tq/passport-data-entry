<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnsuccessfulRegistration extends Model
{
    use HasFactory;

    protected $table = 'unsuccesfull_registration';

    protected $fillable = [
        'id_code',
        'name',
        'company_name',
    ];
}
