<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengabdian;
use App\Models\Bidang;

class DosenPengabdianController extends Controller
{
    // ================================
    // INDEX
    // ================================
    public function index()
    {
        $dosen = Auth::guard('dosen')->user();

        $pengabdian = Pengabdian::where('dosen_id', $dosen->id)
            ->orderBy('tahun', 'desc')
            ->get();

        $bidangList = Bidang::where('is_active', true)
            ->orderBy('nama_bidang')
            ->get();

        return view('dosen.pengabdian.index', [
    'title' => 'Data Pengabdian',
    'pengabdian' => $pengabdian,
    'bidangList' => $bidangList
]);

    }

    // ================================
    // CREATE
    // ================================
    public function create()
    {
        $bidangList = Bidang::where('is_active', true)
            ->orderBy('nama_bidang')
            ->get();

        return view('dosen.pengabdian.create', compact('bidangList'));
    }

    // ================================
    // STORE
    // ================================
    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'bidang_id'  => 'required|exists:bidang,id',
            'tahun'      => 'required|integer',
            'abstrak'    => 'nullable|string',
            'file'       => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $dosen = Auth::guard('dosen')->user();
        if (!$dosen) {
            return redirect()->back()->with('error', 'Session dosen tidak terbaca');
        }

        // Ambil nama bidang (untuk mengisi kolom bidang lama)
        $bidang = Bidang::findOrFail($request->bidang_id);

        // Upload file
        $filePath = null;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('pengabdian', $fileName, 'public');
        }

        Pengabdian::create([
            'dosen_id'  => $dosen->id,
            'judul'     => $request->judul,
            'bidang_id' => $bidang->id,
            'bidang'    => $bidang->nama_bidang, // ✅ isi juga kolom bidang lama
            'tahun'     => $request->tahun,
            'status'    => 'Menunggu Validasi',
            'abstrak'   => $request->abstrak,
            'file_path' => $filePath,
        ]);

        return redirect()->route('dosen.pengabdian.index')
            ->with('success', 'Pengabdian berhasil ditambahkan.');
    }

    // ================================
    // SHOW (DETAIL)
    // ================================
    public function show($id)
    {
        $data = Pengabdian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403, 'Anda tidak memiliki akses ke pengabdian ini.');
        }

        return view('dosen.pengabdian.show', compact('data'));
    }

    // ================================
    // EDIT
    // ================================
    public function edit($id)
    {
        $data = Pengabdian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        $bidangList = Bidang::where('is_active', true)
            ->orderBy('nama_bidang')
            ->get();

        return view('dosen.pengabdian.edit', compact('data', 'bidangList'));
    }

    // ================================
    // UPDATE
    // ================================
    public function update(Request $request, $id)
    {
        $data = Pengabdian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit pengabdian ini.');
        }

        $request->validate([
            'judul'     => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidang,id',
            'tahun'     => 'required|integer',
            'abstrak'   => 'nullable|string',
            'file'      => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $bidang = Bidang::findOrFail($request->bidang_id);

        $filePath = $data->file_path;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
                Storage::disk('public')->delete($data->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('pengabdian', $fileName, 'public');
        }

        $data->update([
            'judul'     => $request->judul,
            'bidang_id' => $bidang->id,
            'bidang'    => $bidang->nama_bidang,
            'tahun'     => $request->tahun,
            'abstrak'   => $request->abstrak,
            'file_path' => $filePath,
        ]);

        return redirect()->route('dosen.pengabdian.show', $data->id)
            ->with('success', 'Data pengabdian berhasil diperbarui!');
    }

    // ================================
    // DELETE
    // ================================
    public function destroy($id)
    {
        $data = Pengabdian::findOrFail($id);

        if ($data->dosen_id != Auth::guard('dosen')->id()) {
            abort(403);
        }

        if ($data->file_path && Storage::disk('public')->exists($data->file_path)) {
            Storage::disk('public')->delete($data->file_path);
        }

        $data->delete();

        return redirect()->route('dosen.pengabdian.index')
            ->with('success', 'Data pengabdian berhasil dihapus.');
    }
}
