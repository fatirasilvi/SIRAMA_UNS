<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengabdian extends Model
{
    protected $fillable = [
        'dosen_id',
    'judul',
    'bidang',
    'bidang_id',
    'research_group_id',
    'tahun',
    'abstrak',
    'file_path',
    'status',
    ];

    // Relasi ke dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Relasi ke bidang
    public function bidangRelation()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    // Accessor nama bidang (sama seperti Penelitian)
    public function getBidangAttribute()
    {
        if ($this->bidang_id && $this->bidangRelation) {
            return $this->bidangRelation->nama_bidang;
        }

        return $this->attributes['bidang'] ?? '-';
    }

    public function researchGroup()
{
    return $this->belongsTo(ResearchGroup::class, 'research_group_id');
}
}
