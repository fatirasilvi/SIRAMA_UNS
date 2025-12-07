<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Dosen extends Authenticatable
{
    protected $table = 'dosen';

    protected $fillable = [
        'nama',
        'nip',
        'email',
        'password',
        'foto',
        'prodi',
        'jabatan',
    ];

    protected $hidden = [
        'password',
    ];

    public function penelitians()
    {
        return $this->hasMany(Penelitian::class, 'dosen_id', 'id');
    }

    public function pengabdians()
{
    return $this->hasMany(Pengabdian::class);
}
}
