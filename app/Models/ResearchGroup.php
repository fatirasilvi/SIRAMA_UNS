<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchGroup extends Model
{
    protected $fillable = [
        'nama_group',
        'deskripsi',
        'ketua',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke pengabdian
    public function pengabdian()
    {
        return $this->hasMany(Pengabdian::class, 'research_group_id');
    }

    public function dosens()
{
    return $this->hasMany(\App\Models\Dosen::class, 'research_group_id');
}

}