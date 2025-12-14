<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prodi;
use Illuminate\Validation\Rule;

class DosenProfilController extends Controller
{
    public function edit()
    {
        $dosen = auth()->guard('dosen')->user();
    $prodiList = Prodi::orderBy('nama')->get();

    return view('dosen.edit-profil', compact('dosen', 'prodiList'));
    }

public function update(Request $request)
{
    $dosen = auth()->guard('dosen')->user();

    $request->validate([
        'nama' => 'required|string|max:255',
        'nip'  => 'required|string|max:50',
        'prodi_id' => ['nullable', Rule::exists('prodis', 'id')],
        'jabatan' => 'nullable|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $dosen->nama = $request->nama;
    $dosen->nip = $request->nip;
    $dosen->prodi_id = $request->prodi_id;
    $dosen->jabatan = $request->jabatan;

    if (\Illuminate\Support\Facades\Schema::hasColumn('dosen', 'prodi')) {
        $dosen->prodi = $request->prodi_id
            ? Prodi::find($request->prodi_id)?->nama
            : null;
    }
    if ($request->hasFile('foto')) {
        $filename = time() . '_' . $request->foto->getClientOriginalName();
        $request->foto->storeAs('public/dosen', $filename);
        $dosen->foto = $filename;
    }

    $dosen->save();

    return back()->with('success', 'Profil berhasil diperbarui');
}


}
