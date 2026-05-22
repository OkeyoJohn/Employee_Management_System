<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'position',
        'department',
        'salary',
        'hire_date',
        'image',
    ];

    public $timestamps = false;
}
