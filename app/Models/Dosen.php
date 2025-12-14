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
        'prodi_id',
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

public function prodi()
{
    return $this->belongsTo(\App\Models\Prodi::class, 'prodi_id');
}

public function researchGroup()
{
    return $this->belongsTo(\App\Models\ResearchGroup::class, 'research_group_id');
}


}
