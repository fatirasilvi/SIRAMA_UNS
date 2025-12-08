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
    $admin = auth()->guard('admin')->user();

    $request->validate([
        'nama' => 'required|string|max:255',
        'nip'  => 'required|string|max:50',
    ]);

    $admin->nama = $request->nama;
    $admin->nip  = $request->nip;

    $admin->save();

    return back()->with('success', 'Profil admin berhasil diperbarui.');
}


}
