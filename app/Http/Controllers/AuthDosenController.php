<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthDosenController extends Controller
{
    /* ===============================
       REGISTER (Sudah Kamu Buat)
    ================================ */

    public function register()
    {
        return view('auth.dosen.register');
    }

    public function registerStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:dosen,nip',
            'email' => 'required|email|unique:dosen,email',
            'password' => 'required|min:6|confirmed',
        ]);

        Dosen::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dosen.login')->with('success', 'Account created successfully. Please login.');
    }


    /* ===============================
       LOGIN
    ================================ */

    public function login()
    {
        return view('auth.dosen.login');
    }

   public function loginStore(Request $request)
{
    $request->validate([
        'nip' => 'required|string',
        'password' => 'required',
    ]);

    if (Auth::guard('dosen')->attempt([
    'nip' => $request->nip,
    'password' => $request->password,
])
) {
    dd('LOGIN BERHASIL', Auth::guard('dosen')->user());
    return redirect()->route('dosen.dashboard');
}

dd('LOGIN GAGAL');

    // =============================

    return back()->withErrors([
        'nip' => 'NIP atau password salah',
    ]);
}

    /* ===============================
       LOGOUT
    ================================ */

    public function logout()
    {
        session()->flush();
        return redirect()->route('dosen.login');
    }

    public function dashboard()
    {
        return view('dosen.index');
    }
}
