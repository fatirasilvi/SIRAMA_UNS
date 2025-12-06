<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penelitian;
use Illuminate\Support\Facades\Auth;

class PenelitianController extends Controller
{
    public function create()
    {
        return view('dosen.penelitian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'bidang'    => 'required|string',
            'tahun'     => 'required|integer',
            'status'    => 'required|string',
            'abstrak'   => 'nullable|string',
            'file'      => 'nullable|file|mimes:pdf,doc,docx|max:5000',
        ]);

        // handle upload file penelitian
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('penelitian_files', 'public');
        }

        Penelitian::create([
            'dosen_id'  => Auth::guard('dosen')->user()->id,
            'judul'     => $request->judul,
            'bidang'    => $request->bidang,
            'tahun'     => $request->tahun,
            'status'    => $request->status,
            'abstrak'   => $request->abstrak,
            'file_path' => $filePath,
        ]);

        return redirect()->route('dosen.penelitian.index')
            ->with('success', 'Penelitian berhasil ditambahkan.');
    }
}
