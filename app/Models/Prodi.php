<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'prodis'; // ✅ penting kalau pernah kepencet jadi "prodi"
    protected $fillable = ['nama'];

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }
}
