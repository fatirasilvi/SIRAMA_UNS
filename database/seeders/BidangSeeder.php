<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    public function run()
    {
        $bidangList = [
            ['nama_bidang' => 'Artificial Intelligence', 'deskripsi' => 'Penelitian terkait kecerdasan buatan'],
            ['nama_bidang' => 'Machine Learning', 'deskripsi' => 'Penelitian pembelajaran mesin'],
            ['nama_bidang' => 'Big Data', 'deskripsi' => 'Penelitian analisis data besar'],
            ['nama_bidang' => 'Internet of Things (IoT)', 'deskripsi' => 'Penelitian perangkat IoT'],
            ['nama_bidang' => 'Cloud Computing', 'deskripsi' => 'Penelitian komputasi awan'],
            ['nama_bidang' => 'Cyber Security', 'deskripsi' => 'Penelitian keamanan siber'],
            ['nama_bidang' => 'Blockchain', 'deskripsi' => 'Penelitian teknologi blockchain'],
            ['nama_bidang' => 'Mobile Computing', 'deskripsi' => 'Penelitian komputasi mobile'],
            ['nama_bidang' => 'Computer Vision', 'deskripsi' => 'Penelitian penglihatan komputer'],
            ['nama_bidang' => 'Natural Language Processing', 'deskripsi' => 'Penelitian pemrosesan bahasa alami'],
            ['nama_bidang' => 'Software Engineering', 'deskripsi' => 'Penelitian rekayasa perangkat lunak'],
            ['nama_bidang' => 'Database Systems', 'deskripsi' => 'Penelitian sistem basis data'],
            ['nama_bidang' => 'Human Computer Interaction', 'deskripsi' => 'Penelitian interaksi manusia-komputer'],
            ['nama_bidang' => 'Computer Networks', 'deskripsi' => 'Penelitian jaringan komputer'],
            ['nama_bidang' => 'Teknologi Pendidikan', 'deskripsi' => 'Penelitian teknologi dalam pendidikan'],
        ];

        foreach ($bidangList as $bidang) {
            Bidang::create($bidang);
        }
    }
}