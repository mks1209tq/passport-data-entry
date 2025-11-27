<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedUser extends Model
{
    use HasFactory;

    protected $table = 'reserved_users';

    protected $fillable = [
        'id_code',
        'name',
        'company_name',
    ];
}
