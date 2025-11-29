<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenDashboardController extends Controller
{
    public function index()
    {
        return view('dosen.index', [
            'title' => 'Dashboard',
            'totalPenelitian' => 2,
            'totalPengabdian' => 1,
            'menungguValidasi' => 1,
            'aktivitas' => [] // nanti kita isi dari database
        ]);
    }
}
