<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminDosenController extends Controller
{
    // ===============================
    // INDEX
    // ===============================
    public function index()
    {
        $dosen = Dosen::orderBy('nama')->get();
        return view('admin.dosen.index', [
    'title' => 'Data Dosen',
    'dosen' => $dosen
]);

    }

    // ===============================
    // FORM TAMBAH DOSEN
    // ===============================
    public function create()
    {
        return view('admin.dosen.create');
    }

    // ===============================
    // SIMPAN DOSEN BARU
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'nip'      => 'required|unique:dosen,nip',
            'email'    => 'required|email|unique:dosen,email',
            'password' => 'required|min:6',
        ]);

        Dosen::create([
            'nama'      => $request->nama,
            'nip'       => $request->nip,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'prodi'     => $request->prodi,
            'jabatan'   => $request->jabatan,
            'is_active' => true,
        ]);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan');
    }

    // ===============================
    // FORM EDIT DOSEN
    // ===============================
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('admin.dosen.edit', compact('dosen'));
    }

    // ===============================
    // UPDATE DOSEN
    // ===============================
    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'nama'   => 'required',
            'nip'    => 'required|unique:dosen,nip,' . $id,
            'email'  => 'required|email|unique:dosen,email,' . $id,
        ]);

        $dosen->update([
            'nama'    => $request->nama,
            'nip'     => $request->nip,
            'email'   => $request->email,
            'prodi'   => $request->prodi,
            'jabatan' => $request->jabatan,
        ]);

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui');
    }

    // ===============================
    // AKTIF / NONAKTIF DOSEN ✅
    // ===============================
    public function toggleStatus($id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->is_active = !$dosen->is_active;
        $dosen->save();

        return back()->with('success', 'Status dosen berhasil diperbarui');
    }
}
