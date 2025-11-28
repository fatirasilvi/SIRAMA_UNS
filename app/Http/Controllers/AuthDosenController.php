<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthDosenController extends Controller
{
    /**
     * Menampilkan halaman register dosen
     */
    public function register()
    {
        return view('auth.dosen.register');
    }

    /**
     * Menyimpan data registrasi dosen
     */
    public function registerStore(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nip'      => 'required|string|max:30|unique:users,nip',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'nip'      => $request->nip,
            'email'    => $request->email,
            'role'     => 'dosen',
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Akun dosen berhasil dibuat. Silakan login.');
    }
}
