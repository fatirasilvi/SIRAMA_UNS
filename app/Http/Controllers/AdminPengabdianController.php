<?php

namespace App\Http\Controllers;

use App\Models\Pengabdian;

class AdminPengabdianController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $pengabdian = Pengabdian::with('dosen')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.pengabdian.index', [
    'title' => 'Validasi Pengabdian',
    'pengabdian' => $pengabdian
]);

    }

    // =========================
    // SHOW DETAIL
    // =========================
    public function show($id)
    {
        $data = Pengabdian::with('dosen')->findOrFail($id);

        return view('admin.pengabdian.show', compact('data'));
    }

    // =========================
    // APPROVE
    // =========================
    public function approve($id)
    {
        $data = Pengabdian::findOrFail($id);
        $data->update(['status' => 'Disetujui']);

        return redirect()->route('admin.pengabdian.index')
            ->with('success', 'Pengabdian berhasil disetujui.');
    }

    // =========================
    // REJECT
    // =========================
    public function reject($id)
    {
        $data = Pengabdian::findOrFail($id);
        $data->update(['status' => 'Ditolak']);

        return redirect()->route('admin.pengabdian.index')
            ->with('success', 'Pengabdian berhasil ditolak.');
    }
}
