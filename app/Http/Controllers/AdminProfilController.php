<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfilController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard('admin')->user();

        return view('admin.edit-profil', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:100',
            'email'    => 'required|email',
            'jabatan'  => 'required|string|max:100',
        ]);

        // ✅ TIDAK ADA FOTO DI SINI

        $admin->nama     = $request->nama;
        $admin->username = $request->username;
        $admin->email    = $request->email;
        $admin->jabatan  = $request->jabatan;
        $admin->save();

        return back()->with('success', 'Profil admin berhasil diperbarui.');
    }
}
