<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';

    protected $fillable = [
        'nama_bidang',
        'deskripsi',
        'is_active',
    ];

    // Relasi ke penelitian
    public function penelitian()
    {
        return $this->hasMany(Penelitian::class, 'bidang_id');
    }
}