<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TqUser extends Model
{
    use HasFactory;

    protected $table = 'tq_users';

    protected $fillable = [
        'id_code',
        'name',
    ];
}
