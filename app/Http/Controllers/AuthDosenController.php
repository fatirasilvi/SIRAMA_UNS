<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthDosenController extends Controller
{
    /* ===============================
       REGISTER
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

        return redirect()->route('dosen.login')->with('success', 'Akun berhasil dibuat. Silakan login.');
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
        'nip' => 'required',
        'password' => 'required',
    ]);

    // ✅ COBA LOGIN SEBAGAI DOSEN
    if (Auth::guard('dosen')->attempt([
        'nip' => $request->nip,
        'password' => $request->password,
    ])) {

        $request->session()->regenerate();

        // CEK STATUS AKTIF DOSEN DI SINI (INI YANG KAMU TANYAKAN!)
        $dosen = Auth::guard('dosen')->user();

        if (!$dosen->is_active) {
            Auth::guard('dosen')->logout();
            return back()->with('error', 'Akun Anda telah dinonaktifkan oleh admin.');
        }

        return redirect()->route('dosen.dashboard');
    }

    // COBA LOGIN SEBAGAI ADMIN
    if (Auth::guard('admin')->attempt([
        'nip' => $request->nip,
        'password' => $request->password,
    ])) {

        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    // JIKA GAGAL SEMUA
    return back()->withErrors([
        'nip' => 'NIP atau Password salah',
    ]);
}

    /* ===============================
       LOGOUT
    ================================ */
    public function logout(Request $request)
    {
        Auth::guard('dosen')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dosen.login');
    }


    /* ===============================
       DASHBOARD
    ================================ */


    /* ===============================
       UPDATE PROFIL DOSEN
    ================================ */
    public function updateProfil(Request $request)
    {
        $user = Auth::guard('dosen')->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'nip'  => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'prodi' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
        ]);

        $user->nama = $request->nama;
        $user->nip = $request->nip;
        $user->prodi = $request->prodi;
        $user->jabatan = $request->jabatan;

        // Upload foto
        if ($request->hasFile('foto')) {
            $filename = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->storeAs('public/dosen', $filename);
            $user->foto = $filename;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
