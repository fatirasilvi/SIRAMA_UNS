<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDosenController extends Controller
{
    public function index()
    {
        $dosen = DB::table('dosen')
            ->orderBy('nama', 'asc')
            ->get();

        return view('admin.dosen.index', compact('dosen'));
    }

    public function toggleStatus($id)
{
    $dosen = DB::table('dosen')->where('id', $id)->first();

    if (!$dosen) {
        return back()->with('error', 'Dosen tidak ditemukan.');
    }

    DB::table('dosen')->where('id', $id)->update([
        'is_active' => !$dosen->is_active
    ]);

    return back()->with('success', 'Status dosen berhasil diperbarui.');
}

}
