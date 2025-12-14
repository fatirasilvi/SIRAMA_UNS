<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class AdminProdiController extends Controller
{
    public function index()
    {$prodis = Prodi::orderBy('nama', 'asc')->get();

        return view('admin.prodi.index', [
            'title'  => 'Data Prodi',
            'prodis' => $prodis
        ]);
    }

    public function create()
    {
        return view('admin.prodi.create', [
        'title' => 'Tambah Prodi'
    ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:prodis,nama',
        ]);

        Prodi::create(['nama' => $request->nama]);

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);

    return view('admin.prodi.edit', [
        'title' => 'Edit Prodi',
        'prodi' => $prodi
    ]);
    }

    public function update(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:prodis,nama,' . $prodi->id,
        ]);

        $prodi->update(['nama' => $request->nama]);

        return redirect()->route('admin.prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();

        return back()->with('success', 'Prodi berhasil dihapus.');
    }
}
