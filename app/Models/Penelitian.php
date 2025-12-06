<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    protected $table = 'penelitians';

    protected $fillable = [
        'dosen_id',
        'judul',
        'bidang',
        'tahun',
        'status',
        'abstrak',
        'file_path',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }
}
