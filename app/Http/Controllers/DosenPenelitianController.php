<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penelitian;

class DosenPenelitianController extends Controller
{
    // ========== LIST PENELITIAN ==========
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        $penelitian = Penelitian::where('dosen_id', $dosen->id)
            ->orderBy('tahun', 'desc')
            ->get();

        return view('dosen.penelitian.index', compact('penelitian'));
    }


    // ========== FORM TAMBAH PENELITIAN ==========
    public function create()
    {
        return view('dosen.penelitian.create');
    }


    // ========== SIMPAN DATA BARU ==========
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'tahun' => 'required|integer',
        ]);

        Penelitian::create([
            'dosen_id' => Auth::guard('dosen')->id(),
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'tahun' => $request->tahun,
            'status' => 'Menunggu Validasi',
        ]);

        return redirect()->route('dosen.penelitian.index')
            ->with('success', 'Penelitian berhasil ditambahkan.');
    }


    // ========== DETAIL PENELITIAN ==========
    public function show($id)
    {
        $data = Penelitian::findOrFail($id);

        // batasi agar dosen hanya bisa akses miliknya sendiri
        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        return view('dosen.penelitian.show', compact('data'));
    }


    // ========== FORM EDIT ==========
    public function edit($id)
    {
        $data = Penelitian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        return view('dosen.penelitian.edit', compact('data'));
    }


    // ========== UPDATE DATA ==========
    public function update(Request $request, $id)
    {
        $data = Penelitian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'tahun' => 'required|integer',
        ]);

        $data->update([
            'judul' => $request->judul,
            'bidang' => $request->bidang,
            'tahun' => $request->tahun,
        ]);

        return redirect()->route('dosen.penelitian.index')
            ->with('success', 'Data penelitian berhasil diperbarui.');
    }


    // ========== HAPUS DATA ==========
    public function destroy($id)
    {
        $data = Penelitian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        $data->delete();

        return redirect()->route('dosen.penelitian.index')
            ->with('success', 'Data penelitian berhasil dihapus.');
    }
}
