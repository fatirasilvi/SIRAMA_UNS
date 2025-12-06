<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenProfilController extends Controller
{
    public function edit()
    {
        $dosen = Auth::user();
        return view('dosen.edit-profil', compact('dosen'));
    }

    public function update(Request $request)
    {
        $dosen = Auth::user();

        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'prodi' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        // Upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            // Pastikan folder ada
            $destination = storage_path('app/public/dosen');
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            // Pindahkan file manual
            $file->move($destination, $filename);

            // Simpan nama file ke database
            $dosen->foto = $filename;
        }


  

        // Update field lain
        $dosen->nama = $request->nama;
        $dosen->nip = $request->nip;
        $dosen->prodi = $request->prodi;
        $dosen->jabatan = $request->jabatan;

        // Simpan semua sekaligus
        $dosen->save();

        return redirect()
            ->route('dosen.edit.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

}
