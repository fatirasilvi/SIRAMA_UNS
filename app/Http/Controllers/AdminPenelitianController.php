<?php

namespace App\Http\Controllers;

use App\Models\Penelitian;
use Illuminate\Http\Request;

class AdminPenelitianController extends Controller
{
    // ✅ LIST SEMUA PENELITIAN
    public function index()
    {
        $penelitian = Penelitian::with('dosen', 'bidangRelation')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.penelitian.index', [
    'title' => 'Validasi Penelitian',
    'penelitian' => $penelitian
]);

    }

    // ✅ DETAIL PENELITIAN
    public function show($id)
    {
        $data = Penelitian::with('dosen', 'bidangRelation')->findOrFail($id);
        return view('admin.penelitian.show', compact('data'));
    }

    // ✅ SETUJUI
    public function approve($id)
    {
        $data = Penelitian::findOrFail($id);
        $data->status = 'Disetujui';
        $data->save();

        return back()->with('success', 'Penelitian berhasil disetujui.');
    }

    // ✅ TOLAK
    public function reject($id)
    {
        $data = Penelitian::findOrFail($id);
        $data->status = 'Ditolak';
        $data->save();

        return back()->with('success', 'Penelitian berhasil ditolak.');
    }
}
