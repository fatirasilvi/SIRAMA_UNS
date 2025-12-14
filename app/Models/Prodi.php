<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $fillable = ['nama'];
    protected $table = 'prodis';

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }
}
