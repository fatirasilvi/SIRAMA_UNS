<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'nama',
        'nip',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];
}
